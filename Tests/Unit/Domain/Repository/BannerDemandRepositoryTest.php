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
 * Test case for class Tx_SfBanners_Domain_Repository_BannerDemandRepository.
 */
class Tx_SfBanners_Domain_Repository_BannerDemandRepositoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

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
	 *
	 * @return void
	 */
	public function setUp() {
		$this->testingFramework = new Tx_Phpunit_Framework('tx_sfbanners', array('tx_phpunit'));
		$this->fixture = $this->objectManager->get('Tx_SfBanners_Domain_Repository_BannerDemandRepository');
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
	public function getDemandFromRepositoryTest() {
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');

		$pidList = array(55,55,56,57,58,59);
		foreach ($pidList as $pid) {
			$this->testingFramework->createRecord('tx_sfbanners_domain_model_bannerdemand', array('pid' => $pid));
		}

		$this->assertEquals(6, (int)$this->fixture->findAll()->count());
	}

}
?>