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
	public function findRecordsByStartingPointTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');

		$pidList = array(55,55,56,57,58,59);
		foreach ($pidList as $pid) {
			$this->testingFramework->createRecord(
				'tx_sfbanners_domain_model_banner', array('pid' => $pid));
		}

		// Simple starting point
		$demand->setStoragePage(55);
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());

		// Multiple starting points
		$demand->setStoragePage('56,57,58');
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());

		// Multiple starting points, including invalid value
		$demand->setStoragePage('57,58,?,59');
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * @test
	 */
	public function findRecordsByCategoryTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');

		$category1 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_category', array('pid' => 0));
		$category2 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_category', array('pid' => 0));
		$category3 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_category', array('pid' => 0));

		$banner1  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => 0));
		$banner2  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => 0));
		$banner3  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => 0));
		$banner4  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => 0));

		/* Create relations */
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner1, $category1, 'category');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner2, $category1, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner2, $category2, 'category');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner3, $category1, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner3, $category3, 'category');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner4, $category1, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner4, $category2, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner', $banner4, $category3, 'category');

		// Simple category test
		$demand->setCategories($category1);
		$this->assertEquals(4, (int)$this->fixture->findDemanded($demand)->count());

		// Multiple category test
		$demand->setCategories($category1 . ',' . $category2);
		$this->assertEquals(4, (int)$this->fixture->findDemanded($demand)->count());

		// Multiple category test, including invalid value
		$demand->setCategories($category2 . ',?,' . $category3);
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());

		// Non existing category test
		$demand->setCategories('9999');
		$this->assertEquals(0, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * @test
	 */
	public function displayModeTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');

		$uids = array();

		for ($i=1; $i<=5; $i++) {
			$uid = $this->testingFramework->createRecord(
				'tx_sfbanners_domain_model_banner', array('pid' => 80, 'sorting' => $i));
			$uids[$i] = $uid;
		}

		// Set starting point
		$demand->setStoragePage(80);

		// All banners with default sorting respected
		$demand->setDisplayMode(0);
		$this->assertEquals(5, (int)$this->fixture->findDemanded($demand)->count());
		$returnedBanners = $this->fixture->findDemanded($demand);
		$returnedUids = array();
		$count = 1;
		foreach ($returnedBanners as $returnedBanner) {
			$returnedUids[$count] = $returnedBanner->getUid();
			$count ++;
		}
		$this->assertSame($uids, $returnedUids);

		// Random one banner
		$demand->setDisplayMode(2);
		$this->assertEquals(1, (int)$this->fixture->findDemanded($demand)->count());

		// @todo - add test for all banners in random mode
	}
}
?>