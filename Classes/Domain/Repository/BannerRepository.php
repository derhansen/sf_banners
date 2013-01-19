<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Torben Hansen <derhansen@gmail.com>, Skyfillers GmbH
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package sf_banners
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_SfBanners_Domain_Repository_BannerRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * @var Tx_Extbase_Persistence_Storage_Typo3DbBackend
	 */
	protected $typo3DbBackend;

	/**
	 * @param Tx_Extbase_Persistence_Storage_Typo3DbBackend $typo3DbBackend
	 */
	public function injectTypo3DbBackend(Tx_Extbase_Persistence_Storage_Typo3DbBackend $typo3DbBackend) {
		$this->typo3DbBackend = $typo3DbBackend;
	}

	/**
	 * Disable the use of storage records, because the StoragePage can be set in the plugin
	 */
	public function initializeObject() {
		$this->defaultQuerySettings = $this->objectManager->create('Tx_Extbase_Persistence_Typo3QuerySettings');
		$this->defaultQuerySettings->setRespectStoragePage(FALSE);
     }

	/**
	 * Returns banners matching the given demand
	 *
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand
	 *
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findDemanded(Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		$query = $this->createQuery();

		$constraints = array();

		if ($demand->getStoragePage() != 0) {
			$pidList = t3lib_div::intExplode(',', $demand->getStoragePage(), TRUE);
			$constraints[]  = $query->in('pid', $pidList);
		}

		if ($demand->getCurrentPageUid()) {
			$excludeConstraints = $query->logicalNot($query->contains('excludepages', $demand->getCurrentPageUid()));
			$constraints[]  = $excludeConstraints;
		}

		if ($demand->getCategories() != 0) {
			$categoryConstraints = array();
			$categories = t3lib_div::intExplode(',', $demand->getCategories(), TRUE);
			foreach ($categories as $category) {
				$categoryConstraints[]  = $query->contains('category', $category);
			}
			if (count($categoryConstraints) > 0) {
				$constraints[] = $query->logicalOr($categoryConstraints);
			}
		}

		$query->matching($query->logicalAnd($constraints));

		/* Get banners without respect to limitations */
		$unfilteredResult = $query->execute();
		$finalQuery = $this->getQueryWithLimitation($unfilteredResult, $demand);

		$result = $this->getResult($finalQuery, $demand);
		return $result;
	}


	/**
	 * Returns the result of the query based on the given displaymode set in demand
	 *
	 * @param Tx_Extbase_Persistence_QueryInterface $query
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand
	 *
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	private function getResult(Tx_Extbase_Persistence_QueryInterface $query, Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		$result = array();
		switch ($demand->getDisplayMode()) {
			case 0:
				$result = $query->execute();
				break;
			case 1:
				$parameters = array();
				$statementParts = $this->typo3DbBackend->parseQuery($query, $parameters);
				$statementParts['orderings'][] = 'RAND()';
				$statement = $this->typo3DbBackend->buildQuery($statementParts, $parameters);
				$query->statement($statement, $parameters);
				$result = $query->execute();
				break;
			case 2:
				$rows = $query->execute()->count();
				$row_number = mt_rand(0, max(0, ($rows - 1)));
				$result = $query->setOffset($row_number)->setLimit(1)->execute();
				break;
		}
		return $result;
	}

	/**
	 * Returns a query of banner-uids with respect to max_impressions and max_clicks
	 *
	 * @param Tx_Extbase_Persistence_QueryResultInterface $result
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand
	 *
	 * @return Tx_Extbase_Persistence_QueryInterface
	 */
	private function getQueryWithLimitation(Tx_Extbase_Persistence_QueryResultInterface $result,
	                                        Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		$bannerUids = array();
		foreach ($result as $banner) {
			/** @var Tx_SfBanners_Domain_Model_Banner $banner */
			if ($banner->getImpressionsMax() > 0 || $banner->getClicksMax() > 0) {
				if (($banner->getImpressionsMax() > 0 && $banner->getClicksMax() > 0)) {
					if ($banner->getImpressions() < $banner->getImpressionsMax() && $banner->getClicks() <
						$banner->getClicksMax()) {
						$bannerUids[] = $banner->getUid();
					}
				} elseif ($banner->getImpressionsMax() > 0 && ($banner->getImpressions() <
					$banner->getImpressionsMax())) {
					$bannerUids[] = $banner->getUid();
				} elseif ($banner->getClicksMax() > 0 && ($banner->getClicks() < $banner->getClicksMax())) {
					$bannerUids[] = $banner->getUid();
				}
			} else {
				$bannerUids[] = $banner->getUid();
			}
		}

		$query = $this->createQuery();
		$query->matching($query->logicalOr($query->in('uid', $bannerUids)));
		return $query;
	}
}
?>