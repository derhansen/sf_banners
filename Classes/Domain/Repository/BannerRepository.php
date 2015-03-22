<?php
namespace DERHANSEN\SfBanners\Domain\Repository;
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use DERHANSEN\SfBanners\Domain\Model\BannerDemand;

/**
 * Banner repository
 *
 * @package sf_banners
 */
class BannerRepository extends Repository {
	/**
	 * Set default sorting
	 *
	 * @var array
	 */
	protected $defaultOrderings = array ('sorting' => QueryInterface::ORDER_ASCENDING);

	/**
	 * Disable the use of storage records, because the StoragePage can be set
	 * in the plugin
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$this->defaultQuerySettings->setRespectStoragePage(FALSE);
	}

	/**
	 * Returns banners matching the given demand
	 *
	 * @param \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand The demand
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findDemanded(BannerDemand $demand) {
		/* Override the default sorting for random mode. Must be called before
			createQuery() */
		if ($demand->getDisplayMode() == 'allRandom') {
			$this->defaultOrderings = array();
		}

		$query = $this->createQuery();

		$constraints = array();

		if ($demand->getStartingPoint() != 0) {
			$pidList = GeneralUtility::intExplode(',', $demand->getStartingPoint(), TRUE);
			$constraints[]  = $query->in('pid', $pidList);
		}

		if ($demand->getCategories() != 0) {
			$categoryConstraints = array();
			$categories = GeneralUtility::intExplode(',', $demand->getCategories(), TRUE);
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
		if ($unfilteredResult->count() > 0) {
			$finalQuery = $this->getQueryWithLimitation($unfilteredResult, $demand);
			$result = $this->getResult($finalQuery, $demand);
		} else {
			$result = $unfilteredResult;
		}
		return $result;
	}


	/**
	 * Returns the result of the query based on the given displaymode set in demand
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query The query
	 * @param \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand The demand
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	protected function getResult(QueryInterface $query, BannerDemand $demand) {
		$result = array();

		// Do not respect syslanguage since we search for uids - @see forge #47192
		$query->getQuerySettings()->setRespectSysLanguage(false);

		switch ($demand->getDisplayMode()) {
			case 'all':
				$result = $query->execute();
				break;
			case 'allRandom':
				$result = $this->objectManager->get('DERHANSEN\\SfBanners\\Persistence\\RandomQueryResult', $query);

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
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $result The result
	 * @param \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand The demand
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
	 */
	protected function getQueryWithLimitation(QueryResultInterface $result, BannerDemand $demand) {
		$banners = $this->getExcludePageBanners($result, $demand);
		$bannerUids = array();
		foreach ($banners as $banner) {
			/** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
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
		if (count($bannerUids) > 0) {
			$query->matching($query->logicalOr($query->in('uid', $bannerUids)));
		} else {
			/* Query should not match any record */
			$query->matching($query->equals('uid', 0));
		}
		return $query;
	}

	/**
	 * Returns all banners in respect to excludepages (recursively if set in banner)
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $result The result
	 * @param \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand The demand
	 * @return array
	 */
	protected function getExcludePageBanners(QueryResultInterface $result, BannerDemand $demand) {
		/** @var \TYPO3\CMS\Core\Database\QueryGenerator $queryGenerator */
		$queryGenerator = $this->objectManager->get('TYPO3\\CMS\\Core\\Database\\QueryGenerator');

		$banners = array();
		/** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
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
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array $banners Banners
	 * @return void
	 */
	public function updateImpressions(QueryResultInterface $banners) {
		foreach ($banners as $banner) {
			/** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
			$banner->increaseImpressions();
			$this->update($banner);
		}
	}
}

