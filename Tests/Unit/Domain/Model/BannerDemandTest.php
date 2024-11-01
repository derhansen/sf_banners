<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Test\Unit\Domain\Model;

use DERHANSEN\SfBanners\Domain\Model\Dto\BannerDemand;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BannerDemandTest extends UnitTestCase
{
    protected BannerDemand $fixture;

    public function setUp(): void
    {
        $this->fixture = new BannerDemand();
    }

    public function tearDown(): void
    {
        unset($this->fixture);
    }

    #[Test]
    public function categoriesCanBeSetTest(): void
    {
        $categories = '1,2,3,4';
        $this->fixture->setCategories($categories);
        self::assertEquals($categories, $this->fixture->getCategories());
    }

    #[Test]
    public function startingPointCanBeSetTest(): void
    {
        $startingPoint = '1';
        $this->fixture->setStartingPoint($startingPoint);
        self::assertEquals($startingPoint, $this->fixture->getStartingPoint());
    }

    #[Test]
    public function displayModeReturnsInitialValueForDisplayModeTest(): void
    {
        self::assertEquals('all', $this->fixture->getDisplayMode());
    }

    #[Test]
    public function displayModeCanBeSetTest(): void
    {
        $displayMode = 'allRandom';
        $this->fixture->setDisplayMode($displayMode);
        self::assertEquals($displayMode, $this->fixture->getDisplayMode());
    }

    #[Test]
    public function currentPageUidCanBeSetTest(): void
    {
        $currentPageUid = 99;
        $this->fixture->setCurrentPageUid($currentPageUid);
        self::assertEquals($currentPageUid, $this->fixture->getCurrentPageUid());
    }

    #[Test]
    public function getMaxResultsReturnsInitialValue(): void
    {
        self::assertEquals(0, $this->fixture->getMaxResults());
    }

    #[Test]
    public function maxResultsCanBeSet(): void
    {
        $this->fixture->setMaxResults(10);
        self::assertEquals(10, $this->fixture->getMaxResults());
    }
}
