<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Torben Hansen <derhansen@gmail.com>, Skyfillers GmbH
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
 * Test case for class Tx_SfBanners_Domain_Model_Banner.
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
class Tx_SfBanners_Domain_Resopitory_BannerRepositoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var Tx_Phpunit_Framework
	 */
	protected $testingFramework;

	/**
	 * @var Tx_SfBanners_Domain_Repository_BannerRepository
	 */
	protected $fixture;

	/**
	 * Setup
	 */
	public function setUp() {
		$this->testingFramework = new Tx_Phpunit_Framework('tx_sfbanners');
		$this->fixture = $this->objectManager->get('Tx_SfBanners_Domain_Repository_BannerRepository');
	}

	/**
	 * TearDown
	 */
	public function tearDown() {
		$this->testingFramework->cleanUp();
		unset($this->testingFramework, $this->fixture);
	}

	/**
	 * @test
	 */
	public function countReturnsPositiveValueIfBannerInRepositoryTest() {
		/* Create dummy record */
		$uidBanner = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array(
			'pid' => 0,
			'title' => 'Testbanner 1'
		));

		$this->assertNotEmpty($this->fixture->findByUid($uidBanner));
	}

	/**
	 * @test
	 */
	public function categoryReturnedIfRelationExistsTest() {
		$uidCategory = $this->testingFramework->createRecord('tx_sfbanners_domain_model_category', array(
			'pid' => 0,
			'title' => 'Testcategory 1',
		));

		/* Create another dummy record and get the uid */
		$uidBanner  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array(
			'pid' => 0,
			'title' => 'Testbanner 2',
		));

		/* Create relation */
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $uidBanner, $uidCategory, 'category');

		/* Test if category gets returned */
		$this->assertEquals($uidCategory, $this->fixture->findByUid($uidBanner)->getCategory()->current()->getUid());
	}

	/**
	 * @test
	 */
	public function findRecordsByStartingPointTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');

		$pidList = array(55,55,56,57,58,59);
		foreach ($pidList as $pid) {
			$this->testingFramework->createRecord(
				'tx_sfbanners_domain_model_banner', array('pid' => $pid));
		}

		// simple starting point
		$demand->setStoragePage(55);
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());

		// multiple starting points
		$demand->setStoragePage('56,57,58');
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());

		// multiple starting points, including invalid values and commas
		$demand->setStoragePage('57,58,?,59');
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());
	}
}
?>