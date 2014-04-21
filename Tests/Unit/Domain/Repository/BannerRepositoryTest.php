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
 */
class Tx_SfBanners_Domain_Repository_BannerRepositoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var Tx_Phpunit_Framework
	 */
	protected $testingFramework;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface The object manager
	 */
	protected $objectManager;

	/**
	 * @var Tx_SfBanners_Domain_Repository_BannerRepository
	 */
	protected $fixture;

	/**
	 * Setup
	 *
	 * @return void
	 */
	public function setUp() {
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->objectManager = clone $objectManager;
		$this->testingFramework = new Tx_Phpunit_Framework('tx_sfbanners', array('tx_phpunit'));
		$this->fixture = $this->objectManager->get('Tx_SfBanners_Domain_Repository_BannerRepository');
	}

	/**
	 * TearDown
	 *
	 * @return void
	 */
	public function tearDown() {
		$this->testingFramework->cleanUp();
		unset($this->testingFramework, $this->fixture);
	}

	/**
	 * Test if records are returned correctly with given startingpoints
	 *
	 * @test
	 * @return void
	 */
	public function findRecordsByStartingPointTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');

		$pidList = array(55,55,56,57,58,59);
		foreach ($pidList as $pid) {
			$this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));
		}

		/* Simple starting point */
		$demand->setStartingPoint(55);
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());

		/* Multiple starting points */
		$demand->setStartingPoint('56,57,58');
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());

		/* Multiple starting points, including invalid value */
		$demand->setStartingPoint('57,58,?,59');
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * Test if records are found by their catagory
	 *
	 * @test
	 * @return void
	 */
	public function findRecordsByCategoryTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$pid = 10;

		$category1 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_category', array('pid' => $pid));
		$category2 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_category', array('pid' => $pid));
		$category3 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_category', array('pid' => $pid));

		$banner1  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));
		$banner2  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));
		$banner3  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));
		$banner4  = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));

		/* Create relations */
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner1, $category1, 'category');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner2, $category1, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner2, $category2, 'category');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner3, $category1, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner3, $category3, 'category');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner4, $category1, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner4, $category2, 'category');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner4, $category3, 'category');

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* Simple category test */
		$demand->setCategories($category1);
		$this->assertEquals(4, (int)$this->fixture->findDemanded($demand)->count());

		/* Multiple category test */
		$demand->setCategories($category1 . ',' . $category2);
		$this->assertEquals(4, (int)$this->fixture->findDemanded($demand)->count());

		/* Multiple category test, including invalid value */
		$demand->setCategories($category2 . ',?,' . $category3);
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());

		/* Non existing category test */
		$demand->setCategories('9999');
		$this->assertEquals(0, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * Test is records are found by their displaymode
	 *
	 * @test
	 * @return void
	 */
	public function findRecordsWithDisplayModeTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$pid = 80;

		$uids = array();

		for ($i = 1; $i <= 5; $i++) {
			$uid = $this->testingFramework->createRecord(
				'tx_sfbanners_domain_model_banner', array('pid' => $pid, 'sorting' => $i));
			$uids[$i] = $uid;
		}

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* All banners with default sorting respected */
		$demand->setDisplayMode('all');
		$this->assertEquals(5, (int)$this->fixture->findDemanded($demand)->count());
		$returnedBanners = $this->fixture->findDemanded($demand);
		$returnedUids = array();
		$count = 1;
		foreach ($returnedBanners as $returnedBanner) {
			$returnedUids[$count] = $returnedBanner->getUid();
			$count ++;
		}
		$this->assertSame($uids, $returnedUids);

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* Random one banner */
		$demand->setDisplayMode('random');
		$this->assertEquals(1, (int)$this->fixture->findDemanded($demand)->count());

		/* All banners with random diplay mode */
		$demand->setDisplayMode('allRandom');
		$this->assertEquals(5, (int)$this->fixture->findDemanded($demand)->count());

		/* Find 100 times with demand, if returned UIDs are always the same, then they are not returned randomly */
		$matchCount = 0;
		for ($j = 1; $j <= 100; $j++) {
			$returnedBanners = $this->fixture->findDemanded($demand);
			$returnedUids = array();
			$count = 1;
			foreach ($returnedBanners as $returnedBanner) {
				$returnedUids[$count] = $returnedBanner->getUid();
				$count ++;
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
	public function findRecordsForSpecialExcludePageUidTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$pid = 95;

		/* Create some pages */
		$pid1 = $this->testingFramework->createFrontEndPage(0,array('title' => 'Testpage4'));
		$pid2 = $this->testingFramework->createFrontEndPage(0,array('title' => 'Testpage5'));
		$pid3 = $this->testingFramework->createFrontEndPage(0,array('title' => 'Testpage6'));

		/* Create some banners */
		$banner1 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));
		$banner2 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));
		$banner3 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid));

		/* Create relations */
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner1, $pid1, 'excludepages');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner1, $pid2, 'excludepages');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner2, $pid1, 'excludepages');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner3, $pid2, 'excludepages');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner3, $pid3, 'excludepages');

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* All banners, which not should be shown on the page with $pid1 */
		$demand->setCurrentPageUid($pid1);
		$this->assertEquals(1, (int)$this->fixture->findDemanded($demand)->count());

		/* All banners, which not should be shown on page with $pid2 */
		$demand->setCurrentPageUid($pid2);
		$this->assertEquals(1, (int)$this->fixture->findDemanded($demand)->count());

		/* All banners, which not should be shown on page with $pid3 */
		$demand->setCurrentPageUid($pid3);
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());

		/* All banners, which not should be shown on page with a non existing pid */
		$demand->setCurrentPageUid(999);
		$this->assertEquals(3, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * Test if records are not returned on pages recursively where they not should be shown
	 *
	 * @test
	 * @return void
	 */
	public function findRecordsForSpecialExcludeRecursivePageUidTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$pid = 96;

		/* Create some pages */
		$pid1 = $this->testingFramework->createFrontEndPage(0, array('title' => 'Testpage7'));
		$pid2 = $this->testingFramework->createFrontEndPage($pid1 ,array('title' => 'Testpage8'));
		$pid3 = $this->testingFramework->createFrontEndPage($pid2 ,array('title' => 'Testpage9'));
		$pid4 = $this->testingFramework->createFrontEndPage(0 ,array('title' => 'Testpage10'));

		/* Create some banners with recursive option */
		$banner1 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner',
			array('pid' => $pid, 'recursive' => 1));
		$banner2 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner',
			array('pid' => $pid, 'recursive' => 1));
		$banner3 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner',
			array('pid' => $pid, 'recursive' => 1));

		/* Create relations */
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner1, $pid1, 'excludepages');
		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner1, $pid4, 'excludepages');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner2, $pid2, 'excludepages');

		$this->testingFramework->createRelationAndUpdateCounter('tx_sfbanners_domain_model_banner',
			$banner3, $pid3, 'excludepages');

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* All banners, which not should be shown on the page with $pid1 */
		$demand->setCurrentPageUid($pid1);
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());

		/* All banners, which not should be shown on page with $pid2 */
		$demand->setCurrentPageUid($pid2);
		$this->assertEquals(1, (int)$this->fixture->findDemanded($demand)->count());

		/* All banners, which not should be shown on page with $pid3 */
		$demand->setCurrentPageUid($pid3);
		$this->assertEquals(0, (int)$this->fixture->findDemanded($demand)->count());

		/* All banners, which not should be shown on page with $pid4 */
		$demand->setCurrentPageUid($pid4);
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * Test if records are not returned, if max impressions reached
	 *
	 * @test
	 * @return void
	 */
	public function findRecordsWithMaxImpressionsTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$pid = 100;

		/* Create some banners */
		$this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'impressions_max' => 0, 'impressions' => 10));
		$this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'impressions_max' => 1000, 'impressions' => 999));
		$this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'impressions_max' => 1000, 'impressions' => 1000));

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* Verify, that 2 records are returned */
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * Test if records are not returned, if max clicks reached
	 *
	 * @test
	 * @return void
	 */
	public function findRecordsWithMaxClicksTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$pid = 100;

		/* Create some banners */
		$this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'clicks_max' => 0, 'clicks' => 10));
		$this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'clicks_max' => 10, 'clicks' => 9));
		$this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'clicks_max' => 20, 'clicks' => 20));

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* Verify, that 2 records are returned */
		$this->assertEquals(2, (int)$this->fixture->findDemanded($demand)->count());
	}

	/**
	 * Test if records are not returned, if max clicks and/or max impressions reached
	 *
	 * @test
	 * @return void
	 */
	public function findRecordsWithMaxImpressionsAndMaxClicksTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$pid = 101;

		/* Create some banners */
		$banner1 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'impressions_max' => 0, 'impressions' => 10, 'clicks' => 0, 'clicks_max' => 10));

		$banner2 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'impressions_max' => 10, 'impressions' => 10, 'clicks' => 0, 'clicks_max' => 10));

		$banner3 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'impressions_max' => 0, 'impressions' => 10, 'clicks' => 10, 'clicks_max' => 10));

		$banner4 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'impressions_max' => 10, 'impressions' => 10, 'clicks' => 10, 'clicks_max' => 10));

		/* Set starting point */
		$demand->setStartingPoint($pid);

		/* Verify, that 2 records are returned */
		$this->assertEquals(1, (int)$this->fixture->findDemanded($demand)->count());
	}
}
?>