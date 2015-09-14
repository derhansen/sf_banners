<?php
namespace DERHANSEN\SfBanners\Test\Unit\Domain\Model;

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

use TYPO3\CMS\Core\Tests\UnitTestCase;
use DERHANSEN\SfBanners\Domain\Model\BannerDemand;

/**
 * Test case for class \DERHANSEN\SfBanners\Domain\Model\BannerDemand.
 */
class BannerDemandTest extends UnitTestCase {
	/**
	 * @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand
	 */
	protected $fixture;

	/**
	 * Set up
	 *
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new BannerDemand();
	}

	/**
	 * Tear down
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * Test if categories can be set
	 *
	 * @test
	 * @return void
	 */
	public function categoriesCanBeSetTest() {
		$categories = '1,2,3,4';
		$this->fixture->setCategories($categories);
		$this->assertEquals($categories, $this->fixture->getCategories());
	}

	/**
	 * Test if startingpoint can be set
	 *
	 * @test
	 * @return void
	 */
	public function startingPointCanBeSetTest() {
		$startingPoint = 1;
		$this->fixture->setStartingPoint($startingPoint);
		$this->assertEquals($startingPoint, $this->fixture->getStartingPoint());
	}

	/**
	 * Test if displaymode returns the correct initial value
	 *
	 * @test
	 * @return void
	 */
	public function displayModeReturnsInitialValueForDisplayModeTest() {
		$this->assertEquals('all', $this->fixture->getDisplayMode());
	}

	/**
	 * Test if displaymode can be set
	 *
	 * @test
	 * @return void
	 */
	public function displayModeCanBeSetTest() {
		$displayMode = 'allRandom';
		$this->fixture->setDisplayMode($displayMode);
		$this->assertEquals($displayMode, $this->fixture->getDisplayMode());
	}

	/**
	 * Test if the current page uid can be set
	 *
	 * @test
	 * @return void
	 */
	public function currentPageUidCanBeSetTest() {
		$currentPageUid = 99;
		$this->fixture->setCurrentPageUid($currentPageUid);
		$this->assertEquals($currentPageUid, $this->fixture->getCurrentPageUid());
	}
}
