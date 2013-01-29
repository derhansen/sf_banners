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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_SfBanners_Domain_Model_BannerDemand.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Banner Management
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class Tx_SfBanners_Domain_Model_BannerDemandTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_SfBanners_Domain_Model_BannerDemand
	 */
	protected $fixture;

	/**
	 * Set up
	 *
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new Tx_SfBanners_Domain_Model_BannerDemand();
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
	 * @test
	 * @return void
	 */
	public function categoriesCanBeSetTest() {
		$categories = '1,2,3,4';
		$this->fixture->setCategories($categories);
		$this->assertEquals($categories, $this->fixture->getCategories());
	}

	/**
	 * @test
	 * @return void
	 */
	public function startingPointCanBeSetTest() {
		$startingPoint = 1;
		$this->fixture->setStartingPoint($startingPoint);
		$this->assertEquals($startingPoint, $this->fixture->getStartingPoint());
	}

	/**
	 * @test
	 * @return void
	 */
	public function displayModeReturnsInitialValueForDisplayModeTest() {
		$this->assertEquals(0, $this->fixture->getDisplayMode());
	}

	/**
	 * @test
	 * @return void
	 */
	public function displayModeCanBeSetTest() {
		$displayMode = 1;
		$this->fixture->setDisplayMode($displayMode);
		$this->assertEquals($displayMode, $this->fixture->getDisplayMode());
	}

	/**
	 * @test
	 * @return void
	 */
	public function currentPageUidCanBeSetTest() {
		$currentPageUid = 99;
		$this->fixture->setCurrentPageUid($currentPageUid);
		$this->assertEquals($currentPageUid, $this->fixture->getCurrentPageUid());
	}
}
?>