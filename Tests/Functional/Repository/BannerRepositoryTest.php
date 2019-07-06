<?php
namespace DERHANSEN\SfBanners\Tests\Functional\Repository;

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
use DERHANSEN\SfBanners\Domain\Repository\BannerRepository;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Test case for class \DERHANSEN\SfBanners\Domain\Model\Banner.
 */
class BannerRepositoryTest extends FunctionalTestCase
{

    /** @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface The object manager */
    protected $objectManager;

    /** @var \DERHANSEN\SfBanners\Domain\Repository\BannerRepository */
    protected $bannerRepository;

    /** @var array */
    protected $testExtensionsToLoad = ['typo3conf/ext/sf_banners'];

    /**
     * Setup
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->bannerRepository = $this->objectManager->get(BannerRepository::class);

        $this->importDataSet(__DIR__ . '/../Fixtures/sys_category.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/pages.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_sfbanners_domain_model_banner.xml');
    }

    /**
     * Test if records are returned correctly with given startingpoints
     *
     * @test
     * @return void
     */
    public function findRecordsByStartingPointTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
        $demand = new BannerDemand();

        /* Simple starting point */
        $demand->setStartingPoint(55);
        $this->assertEquals(2, count($this->bannerRepository->findDemanded($demand)));

        /* Multiple starting points */
        $demand->setStartingPoint('56,57,58');
        $this->assertEquals(3, count($this->bannerRepository->findDemanded($demand)));

        /* Multiple starting points, including invalid value */
        $demand->setStartingPoint('57,58,?,59');
        $this->assertEquals(3, count($this->bannerRepository->findDemanded($demand)));
    }

    /**
     * Test if records are found by their catagory
     *
     * @test
     * @return void
     */
    public function findRecordsByCategoryTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
        $demand = new BannerDemand();

        /* Set starting point */
        $demand->setStartingPoint(10);

        /* Simple category test */
        $demand->setCategories('10');
        $this->assertEquals(4, count($this->bannerRepository->findDemanded($demand)));

        /* Multiple category test */
        $demand->setCategories('10,11');
        $this->assertEquals(4, count($this->bannerRepository->findDemanded($demand)));

        /* Multiple category test, including invalid value */
        $demand->setCategories('11,?,12');
        $this->assertEquals(3, count($this->bannerRepository->findDemanded($demand)));

        /* Non existing category test */
        $demand->setCategories('9999');
        $this->assertEquals(0, count($this->bannerRepository->findDemanded($demand)));
    }

    /**
     * Test is records are found by their displaymode
     *
     * @test
     * @return void
     */
    public function findRecordsWithDisplayModeTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
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
        $this->assertEquals(5, count($this->bannerRepository->findDemanded($demand)));
        $returnedBanners = $this->bannerRepository->findDemanded($demand);
        $returnedUids = [];
        $count = 1;
        foreach ($returnedBanners as $returnedBanner) {
            $returnedUids[$count] = $returnedBanner->getUid();
            $count++;
        }
        $this->assertSame($uids, $returnedUids);

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Random one banner */
        $demand->setDisplayMode('random');
        $this->assertEquals(1, count($this->bannerRepository->findDemanded($demand)));

        /* All banners with random diplay mode */
        $demand->setDisplayMode('allRandom');
        $this->assertEquals(5, count($this->bannerRepository->findDemanded($demand)));

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
        $this->assertLessThan(100, $matchCount);
    }

    /**
     * Test if records are not returned on pages where they not should be shown
     *
     * @test
     * @return void
     */
    public function findRecordsForSpecialExcludePageUidTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
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
        $this->assertEquals(1, count($this->bannerRepository->findDemanded($demand)));

        /* All banners, which not should be shown on page with $pid2 */
        $demand->setCurrentPageUid($pid2);
        $this->assertEquals(1, count($this->bannerRepository->findDemanded($demand)));

        /* All banners, which not should be shown on page with $pid3 */
        $demand->setCurrentPageUid($pid3);
        $this->assertEquals(2, count($this->bannerRepository->findDemanded($demand)));

        /* All banners, which not should be shown on page with a non existing pid */
        $demand->setCurrentPageUid(999);
        $this->assertEquals(3, count($this->bannerRepository->findDemanded($demand)));
    }

    /**
     * Test if records are not returned on pages recursively where they not should be shown
     *
     * @test
     * @return void
     */
    public function findRecordsForSpecialExcludeRecursivePageUidTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
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
        $this->assertEquals(2, count($this->bannerRepository->findDemanded($demand)));

        /* All banners, which not should be shown on page with $pid2 */
        $demand->setCurrentPageUid($pid2);
        $this->assertEquals(1, count($this->bannerRepository->findDemanded($demand)));

        /* All banners, which not should be shown on page with $pid3 */
        $demand->setCurrentPageUid($pid3);
        $this->assertEquals(0, count($this->bannerRepository->findDemanded($demand)));

        /* All banners, which not should be shown on page with $pid4 */
        $demand->setCurrentPageUid($pid4);
        $this->assertEquals(2, count($this->bannerRepository->findDemanded($demand)));
    }

    /**
     * Test if records are not returned, if max impressions reached
     *
     * @test
     * @return void
     */
    public function findRecordsWithMaxImpressionsTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
        $demand = new BannerDemand();
        $pid = 100;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 2 records are returned */
        $this->assertEquals(2, count($this->bannerRepository->findDemanded($demand)));
    }

    /**
     * Test if records are not returned, if max clicks reached
     *
     * @test
     * @return void
     */
    public function findRecordsWithMaxClicksTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
        $demand = new BannerDemand();
        $pid = 101;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 2 records are returned */
        $this->assertEquals(2, count($this->bannerRepository->findDemanded($demand)));
    }

    /**
     * Test if records are not returned, if max clicks and/or max impressions reached
     *
     * @test
     * @return void
     */
    public function findRecordsWithMaxImpressionsAndMaxClicksTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
        $demand = new BannerDemand();
        $pid = 102;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 1 record are returned */
        $this->assertEquals(1, count($this->bannerRepository->findDemanded($demand)));
    }

    /**
     * Test if expected amount of records are returned, if a mex result is set
     *
     * @test
     * @return void
     */
    public function findRecordsWithMaxResultsTest()
    {
        /** @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand $demand */
        $demand = new BannerDemand();
        $pid = 103;

        /* Set starting point */
        $demand->setStartingPoint($pid);

        /* Verify, that 5 record are returned */
        $this->assertEquals(5, count($this->bannerRepository->findDemanded($demand)));

        $demand->setMaxResults(2);
        $this->assertEquals(2, count($this->bannerRepository->findDemanded($demand)));
    }
}
