<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Test\Unit\Domain\Model;

use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case for class \DERHANSEN\SfBanners\Domain\Model\BannerDemand.
 */
class BannerDemandTest extends UnitTestCase
{
    /**
     * @var BannerDemand
     */
    protected $fixture;

    /**
     * Set up
     */
    public function setUp(): void
    {
        $this->fixture = new BannerDemand();
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        unset($this->fixture);
    }

    /**
     * Test if categories can be set
     *
     * @test
     */
    public function categoriesCanBeSetTest()
    {
        $categories = '1,2,3,4';
        $this->fixture->setCategories($categories);
        self::assertEquals($categories, $this->fixture->getCategories());
    }

    /**
     * Test if startingpoint can be set
     *
     * @test
     */
    public function startingPointCanBeSetTest()
    {
        $startingPoint = '1';
        $this->fixture->setStartingPoint($startingPoint);
        self::assertEquals($startingPoint, $this->fixture->getStartingPoint());
    }

    /**
     * Test if displaymode returns the correct initial value
     *
     * @test
     */
    public function displayModeReturnsInitialValueForDisplayModeTest()
    {
        self::assertEquals('all', $this->fixture->getDisplayMode());
    }

    /**
     * Test if displaymode can be set
     *
     * @test
     */
    public function displayModeCanBeSetTest()
    {
        $displayMode = 'allRandom';
        $this->fixture->setDisplayMode($displayMode);
        self::assertEquals($displayMode, $this->fixture->getDisplayMode());
    }

    /**
     * Test if the current page uid can be set
     *
     * @test
     */
    public function currentPageUidCanBeSetTest()
    {
        $currentPageUid = 99;
        $this->fixture->setCurrentPageUid($currentPageUid);
        self::assertEquals($currentPageUid, $this->fixture->getCurrentPageUid());
    }

    /**
     * @test
     */
    public function getMaxResultsReturnsInitialValue()
    {
        self::assertEquals(0, $this->fixture->getMaxResults());
    }

    /**
     * @test
     */
    public function maxResultsCanBeSet()
    {
        $this->fixture->setMaxResults(10);
        self::assertEquals(10, $this->fixture->getMaxResults());
    }
}
