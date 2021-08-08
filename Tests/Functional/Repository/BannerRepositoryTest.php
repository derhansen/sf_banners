<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Tests\Functional\Repository;

use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use DERHANSEN\SfBanners\Domain\Repository\BannerRepository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case for class \DERHANSEN\SfBanners\Domain\Model\Banner.
 */
class BannerRepositoryTest extends FunctionalTestCase
{
    /** @var BannerRepository */
    protected $bannerRepository;

    /** @var array */
    protected $testExtensionsToLoad = ['typo3conf/ext/sf_banners'];

    /**
     * Setup
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->bannerRepository = $this->getContainer()->get(BannerRepository::class);

        $this->importDataSet(__DIR__ . '/../Fixtures/sys_category.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/pages.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_sfbanners_domain_model_banner.xml');
    }

    /**
     * Test if records are returned correctly with given startingpoints
     *
     * @test
     */
    public function findRecordsByStartingPointTest()
    {
        $demand = new BannerDemand();

        /* Simple starting point */
        $demand->setStartingPoint(55);
        self::assertCount(2, $this->bannerRepository->findDemanded($demand));

        /* Multiple starting points */
        $demand->setStartingPoint('56,57,58');
        self::assertCount(3, $this->bannerRepository->findDemanded($demand));

        /* Multiple starting points, including invalid value */
        $demand->setStartingPoint('57,58,?,59');
        self::assertCount(3, $this->bannerRepository->findDemanded($demand));
    }

    /**
     * Test if records are found by their catagory
     *
     * @test
     */
    public function findRecordsByCategoryTest()
    {
        $demand = new BannerDemand();

        /* Set starting point */
        $demand->setStartingPoint(10);

        /* Simple category test */
        $demand->setCategories('10');
        self::assertCount(4, $this->bannerRepository->findDemanded($demand));

        /* Multiple category test */
        $demand->setCategories('10,11');
        self::assertCount(4, $this->bannerRepository->findDemanded($demand));

        /* Multiple category test, including invalid value */
        $demand->setCategories('11,?,12');
        self::assertCount(3, $this->bannerRepository->findDemanded($demand));

        /* Non existing category test */
        $demand->setCategories('9999');
        self::assertCount(0, $this->bannerRepository->findDemanded($demand));
    }

    /**
     * Test is records are found by their displaymode
     *
     * @test
     */
    public function findRecordsWithDisplayModeTest()
    {
        $demand = new BannerDemand();
        $pid = 80;
        $uids = [
            1 => 20,
            2 => 21,
            3 => 22,
            4 => 23,
            5 => 24
        ];

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* All banners with default sorting respected */
        $demand->setDisplayMode('all');
        self::assertCount(5, $this->bannerRepository->findDemanded($demand));
        $returnedBanners = $this->bannerRepository->findDemanded($demand);
        $returnedUids = [];
        $count = 1;
        foreach ($returnedBanners as $returnedBanner) {
            $returnedUids[$count] = $returnedBanner->getUid();
            $count++;
        }
        self::assertSame($uids, $returnedUids);

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Random one banner */
        $demand->setDisplayMode('random');
        self::assertCount(1, $this->bannerRepository->findDemanded($demand));

        /* All banners with random diplay mode */
        $demand->setDisplayMode('allRandom');
        self::assertCount(5, $this->bannerRepository->findDemanded($demand));

        /* Find 100 times with demand, if returned UIDs are always the same, then they are not returned randomly */
        $matchCount = 0;
        for ($j = 1; $j <= 100; $j++) {
            $returnedBanners = $this->bannerRepository->findDemanded($demand);
            $returnedUids = [];
            $count = 1;
            foreach ($returnedBanners as $returnedBanner) {
                $returnedUids[$count] = $returnedBanner->getUid();
                $count++;
            }
            if ($uids === $returnedUids) {
                $matchCount += 1;
            }
        }
        self::assertLessThan(100, $matchCount);
    }

    /**
     * Test if records are not returned on pages where they not should be shown
     *
     * @test
     */
    public function findRecordsForSpecialExcludePageUidTest()
    {
        $demand = new BannerDemand();
        $pid = 95;

        /* Define PIDs */
        $pid1 = 4;
        $pid2 = 5;
        $pid3 = 6;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* All banners, which not should be shown on the page with $pid1 */
        $demand->setCurrentPageUid($pid1);
        self::assertCount(1, $this->bannerRepository->findDemanded($demand));

        /* All banners, which not should be shown on page with $pid2 */
        $demand->setCurrentPageUid($pid2);
        self::assertCount(1, $this->bannerRepository->findDemanded($demand));

        /* All banners, which not should be shown on page with $pid3 */
        $demand->setCurrentPageUid($pid3);
        self::assertCount(2, $this->bannerRepository->findDemanded($demand));

        /* All banners, which not should be shown on page with a non existing pid */
        $demand->setCurrentPageUid(999);
        self::assertCount(3, $this->bannerRepository->findDemanded($demand));
    }

    /**
     * Test if records are not returned on pages recursively where they not should be shown
     *
     * @test
     */
    public function findRecordsForSpecialExcludeRecursivePageUidTest()
    {
        $demand = new BannerDemand();
        $pid = 96;

        /* Define PIDs */
        $pid1 = 7;
        $pid2 = 8;
        $pid3 = 9;
        $pid4 = 10;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* All banners, which not should be shown on the page with $pid1 */
        $demand->setCurrentPageUid($pid1);
        self::assertCount(2, $this->bannerRepository->findDemanded($demand));

        /* All banners, which not should be shown on page with $pid2 */
        $demand->setCurrentPageUid($pid2);
        self::assertCount(1, $this->bannerRepository->findDemanded($demand));

        /* All banners, which not should be shown on page with $pid3 */
        $demand->setCurrentPageUid($pid3);
        self::assertCount(0, $this->bannerRepository->findDemanded($demand));

        /* All banners, which not should be shown on page with $pid4 */
        $demand->setCurrentPageUid($pid4);
        self::assertCount(2, $this->bannerRepository->findDemanded($demand));
    }

    /**
     * Test if records are not returned, if max impressions reached
     *
     * @test
     */
    public function findRecordsWithMaxImpressionsTest()
    {
        $demand = new BannerDemand();
        $pid = 100;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 2 records are returned */
        self::assertCount(2, $this->bannerRepository->findDemanded($demand));
    }

    /**
     * Test if records are not returned, if max clicks reached
     *
     * @test
     */
    public function findRecordsWithMaxClicksTest()
    {
        $demand = new BannerDemand();
        $pid = 101;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 2 records are returned */
        self::assertCount(2, $this->bannerRepository->findDemanded($demand));
    }

    /**
     * Test if records are not returned, if max clicks and/or max impressions reached
     *
     * @test
     */
    public function findRecordsWithMaxImpressionsAndMaxClicksTest()
    {
        $demand = new BannerDemand();
        $pid = 102;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 1 record are returned */
        self::assertCount(1, $this->bannerRepository->findDemanded($demand));
    }

    /**
     * Test if expected amount of records are returned, if a mex result is set
     *
     * @test
     */
    public function findRecordsWithMaxResultsTest()
    {
        $demand = new BannerDemand();
        $pid = 103;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 5 record are returned */
        self::assertCount(5, $this->bannerRepository->findDemanded($demand));

        $demand->setMaxResults(2);
        self::assertCount(2, $this->bannerRepository->findDemanded($demand));
    }
}
