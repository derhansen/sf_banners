<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Domain\Repository;

use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use DERHANSEN\SfBanners\Utility\PageUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class BannerRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = ['sorting' => QueryInterface::ORDER_ASCENDING];

    /**
     * Disable the use of storage records, because the StoragePage can be set
     * in the plugin
     */
    public function initializeObject(): void
    {
        $this->defaultQuerySettings = GeneralUtility::makeInstance(Typo3QuerySettings::class);
        $this->defaultQuerySettings->setRespectStoragePage(false);
    }

    /**
     * Returns banners matching the given demand
     *
     * @return array|QueryResultInterface
     */
    public function findDemanded(BannerDemand $demand)
    {
        /* Override the default sorting for random mode. Must be called before createQuery() */
        if ($demand->getDisplayMode() === 'allRandom') {
            $this->defaultOrderings = [];
        }

        $query = $this->createQuery();

        $constraints = [];

        if ($demand->getStartingPoint() !== '0' && $demand->getStartingPoint() !== '') {
            $pidList = GeneralUtility::intExplode(',', $demand->getStartingPoint(), true);
            $constraints[] = $query->in('pid', $pidList);
        }

        if ($demand->getCategories() !== '0' && $demand->getCategories() !== '') {
            $categoryConstraints = [];
            $categories = GeneralUtility::intExplode(',', $demand->getCategories(), true);
            foreach ($categories as $category) {
                $categoryConstraints[] = $query->contains('category', $category);
            }
            if (count($categoryConstraints) > 0) {
                $constraints[] = $query->logicalOr(...$categoryConstraints);
            }
        }
        $query->matching($query->logicalAnd(...$constraints));

        /* Get banners without respect to limitations */
        $unfilteredResult = $query->execute();
        if (count($unfilteredResult) > 0) {
            $filteredResult = $this->applyBannerLimitations($unfilteredResult, $demand);
            $bannersByDisplayMode = $this->getBannersByDisplayMode($filteredResult, $demand);
            $result = $this->getBannersByMaxResults($bannersByDisplayMode, $demand);
        } else {
            $result = $unfilteredResult;
        }
        return $result;
    }

    /**
     * Returns the banners by the displayMode set in the demand
     */
    protected function getBannersByDisplayMode(array $filteredResult, BannerDemand $demand): array
    {
        $result = [];

        switch ($demand->getDisplayMode()) {
            case 'all':
                $result = $filteredResult;
                break;
            case 'allRandom':
                shuffle($filteredResult);
                $result = $filteredResult;
                break;
            case 'random':
                shuffle($filteredResult);
                $result = isset($filteredResult[0]) ? [$filteredResult[0]] : [];
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * Returns the banners by maxResults set in the demand
     */
    protected function getBannersByMaxResults(array $banners, BannerDemand $bannerDemand): array
    {
        $result = $banners;
        if ($bannerDemand->getMaxResults() > 0 && count($banners) > $bannerDemand->getMaxResults()) {
            $result = array_slice($banners, 0, $bannerDemand->getMaxResults());
        }
        return $result;
    }

    /**
     * Applies banner limitations to the given queryResult and returns remaining banners as array
     */
    protected function applyBannerLimitations(QueryResultInterface $result, BannerDemand $demand): array
    {
        $banners = $this->getExcludePageBanners($result, $demand);
        $resultingBanners = [];
        foreach ($banners as $banner) {
            if ($banner->getImpressionsMax() > 0 || $banner->getClicksMax() > 0) {
                if (($banner->getImpressionsMax() > 0 && $banner->getClicksMax() > 0)) {
                    if ($banner->getImpressions() < $banner->getImpressionsMax() && $banner->getClicks() <
                        $banner->getClicksMax()
                    ) {
                        $resultingBanners[] = $banner;
                    }
                } elseif ($banner->getImpressionsMax() > 0 && ($banner->getImpressions() <
                        $banner->getImpressionsMax())
                ) {
                    $resultingBanners[] = $banner;
                } elseif ($banner->getClicksMax() > 0 && ($banner->getClicks() < $banner->getClicksMax())) {
                    $resultingBanners[] = $banner;
                }
            } else {
                $resultingBanners[] = $banner;
            }
        }
        return $resultingBanners;
    }

    /**
     * Returns all banners in respect to excludepages (recursively if set in banner)
     */
    protected function getExcludePageBanners(QueryResultInterface $result, BannerDemand $demand): array
    {
        $banners = [];
        foreach ($result as $banner) {
            $excludePages = [];
            foreach ($banner->getExcludepages() as $excludePage) {
                if ($banner->getRecursive()) {
                    $pidList = PageUtility::extendPidListByChildren((string)$excludePage->getUid(), 255);
                    $pidArray = GeneralUtility::intExplode(',', $pidList, true);
                    $excludePages = [...$excludePages, ...$pidArray];
                } else {
                    $excludePages[] = $excludePage->getUid();
                }
            }
            if (!in_array($demand->getCurrentPageUid(), $excludePages, true)) {
                $banners[] = $banner;
            }
        }
        return $banners;
    }

    /**
     * Updates the impressions counter for each banner
     */
    public function updateImpressions(array $banners): void
    {
        foreach ($banners as $banner) {
            $banner->increaseImpressions();
            $this->update($banner);
        }
    }
}
