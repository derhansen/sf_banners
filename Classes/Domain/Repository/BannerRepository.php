<?php
namespace DERHANSEN\SfBanners\Domain\Repository;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Banner repository
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class BannerRepository extends Repository
{
    /**
     * Set default sorting
     *
     * @var array
     */
    protected $defaultOrderings = ['sorting' => QueryInterface::ORDER_ASCENDING];

    /**
     * Disable the use of storage records, because the StoragePage can be set
     * in the plugin
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(false);
    }

    /**
     * Returns banners matching the given demand
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand The demand
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findDemanded(BannerDemand $demand)
    {
        /* Override the default sorting for random mode. Must be called before
            createQuery() */
        if ($demand->getDisplayMode() == 'allRandom') {
            $this->defaultOrderings = [];
        }

        $query = $this->createQuery();

        $constraints = [];

        if ($demand->getStartingPoint() != 0) {
            $pidList = GeneralUtility::intExplode(',', $demand->getStartingPoint(), true);
            $constraints[] = $query->in('pid', $pidList);
        }

        if ($demand->getCategories() != 0) {
            $categoryConstraints = [];
            $categories = GeneralUtility::intExplode(',', $demand->getCategories(), true);
            foreach ($categories as $category) {
                $categoryConstraints[] = $query->contains('category', $category);
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
    protected function getResult(QueryInterface $query, BannerDemand $demand)
    {
        $result = [];

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
    protected function getQueryWithLimitation(QueryResultInterface $result, BannerDemand $demand)
    {
        $banners = $this->getExcludePageBanners($result, $demand);
        $bannerUids = [];
        foreach ($banners as $banner) {
            /** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
            if ($banner->getImpressionsMax() > 0 || $banner->getClicksMax() > 0) {
                if (($banner->getImpressionsMax() > 0 && $banner->getClicksMax() > 0)) {
                    if ($banner->getImpressions() < $banner->getImpressionsMax() && $banner->getClicks() <
                        $banner->getClicksMax()
                    ) {
                        $bannerUids[] = $banner->getUid();
                    }
                } elseif ($banner->getImpressionsMax() > 0 && ($banner->getImpressions() <
                        $banner->getImpressionsMax())
                ) {
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
    protected function getExcludePageBanners(QueryResultInterface $result, BannerDemand $demand)
    {
        /** @var \TYPO3\CMS\Core\Database\QueryGenerator $queryGenerator */
        $queryGenerator = $this->objectManager->get('TYPO3\\CMS\\Core\\Database\\QueryGenerator');

        $banners = [];
        /** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
        foreach ($result as $banner) {
            $excludePages = [];
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
    public function updateImpressions(QueryResultInterface $banners)
    {
        foreach ($banners as $banner) {
            /** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
            $banner->increaseImpressions();
            $this->update($banner);
        }
    }
}
