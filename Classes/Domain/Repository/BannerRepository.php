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
 * Banner repository
 *
 * @package sf_banners
 */
class Tx_SfBanners_Domain_Repository_BannerRepository extends Tx_Extbase_Persistence_Repository {
	/**
	 * Set default sorting
	 *
	 * @var array
	 */
	protected $defaultOrderings = array ('sorting' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING);

	/**
	 * @var Tx_Extbase_Persistence_Storage_Typo3DbBackend
	 */
	protected $typo3DbBackend;

	/**
	 * Inject the typo3dbbackend
	 *
	 * @param Tx_Extbase_Persistence_Storage_Typo3DbBackend $typo3DbBackend
	 * @return void
	 */
	public function injectTypo3DbBackend(Tx_Extbase_Persistence_Storage_Typo3DbBackend $typo3DbBackend) {
		$this->typo3DbBackend = $typo3DbBackend;
	}

	/**
	 * Disable the use of storage records, because the StoragePage can be set
	 * in the plugin
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->defaultQuerySettings = $this->objectManager->create('Tx_Extbase_Persistence_Typo3QuerySettings');
		$this->defaultQuerySettings->setRespectStoragePage(FALSE);
	}

	/**
	 * Returns banners matching the given demand
	 *
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand The demand
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findDemanded(Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		/* Override the default sorting for random mode. Must be called before
			createQuery() */
		if ($demand->getDisplayMode() == 'allRandom') {
			$this->defaultOrderings = array();
		}

		$query = $this->createQuery();

		$constraints = array();

		if ($demand->getStartingPoint() != 0) {
			$pidList = t3lib_div::intExplode(',', $demand->getStartingPoint(), TRUE);
			$constraints[]  = $query->in('pid', $pidList);
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
	 * @param Tx_Extbase_Persistence_QueryInterface $query The query
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand The demand
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	protected function getResult(Tx_Extbase_Persistence_QueryInterface $query, Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		$result = array();
		switch ($demand->getDisplayMode()) {
			case 'all':
				$result = $query->execute();
				break;
			case 'allRandom':
				$parameters = array();
				$statementParts = $this->typo3DbBackend->parseQuery($query, $parameters);
				$statementParts['orderings'][] = 'RAND()';
				$statement = $this->typo3DbBackend->buildQuery($statementParts, $parameters);
				$query->statement($statement, $parameters);
				$result = $query->execute();
				break;
			case 'random':
				$rows = $query->execute()->count();
				$rowNumber = mt_rand(0, max(0, ($rows - 1)));
				$result = $query->setOffset($rowNumber)->setLimit(1)->execute();
				break;
			default:
				break;
		}
		return $result;
	}

	/**
	 * Returns a query of banner-uids with respect to max_impressions and max_clicks
	 *
	 * @param Tx_Extbase_Persistence_QueryResultInterface $result The result
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand The demand
	 * @return Tx_Extbase_Persistence_QueryInterface
	 */
	protected function getQueryWithLimitation(Tx_Extbase_Persistence_QueryResultInterface $result,
											Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		$banners = $this->getExcludePageBanners($result, $demand);
		$bannerUids = array();
		foreach ($banners as $banner) {
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

	/**
	 * Returns all banners in respect to excludepages (recursively if set in banner)
	 *
	 * @param Tx_Extbase_Persistence_QueryResultInterface $result The result
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand The demand
	 * @return array
	 */
	protected function getExcludePageBanners(Tx_Extbase_Persistence_QueryResultInterface $result,
											Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		/** @var t3lib_queryGenerator $queryGenerator */
		$queryGenerator = $this->objectManager->get('t3lib_queryGenerator');

		$banners = array();
		/** @var Tx_SfBanners_Domain_Model_Banner $banner */
		foreach ($result as $banner) {
			$excludePages = array();
			foreach ($banner->getExcludepages() as $excludePage) {
				if ($banner->getRecursive()) {
					$pidList = $queryGenerator->getTreeList($excludePage->getUid(), 255, 0, 1);
					$excludePages = array_merge($excludePages, explode(',', $pidList));
				} else {
					$excludePages[] = $excludePage->getUid();
				}
			}
			if (!in_array($demand->getCurrentPageUid(), $excludePages)) {
				$banners[] = $banner;
			}
		}
		return $banners;
	}

	/**
	 * Updates the impressions counter for each banner
	 *
	 * @param Tx_Extbase_Persistence_QueryResultInterface $banners Banners
	 * @return void
	 */
	public function updateImpressions(Tx_Extbase_Persistence_QueryResultInterface $banners) {
		foreach ($banners as $banner) {
			/** @var Tx_SfBanners_Domain_Model_Banner $banner */
			$banner->increaseImpressions();
			$this->update($banner);
		}
	}
}
?>