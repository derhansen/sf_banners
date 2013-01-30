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
 *  the Free Software Foundation; either version 3 of the License, or
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
class Tx_SfBanners_Service_BannerServiceTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Phpunit_Framework
	 */
	protected $testingFramework;

	/**
	 * @var Tx_SfBanners_Domain_Repository_BannerRepository
	 */
	protected $bannerRepository;

	/**
	 * @var Tx_SfBanners_Service_BannerService
	 */
	protected $bannerService;

	/**
	 * Set up
	 *
	 * @return void
	 */
	public function setUp() {
		$this->bannerService = new Tx_SfBanners_Service_BannerService();
		$this->testingFramework = new Tx_Phpunit_Framework('tx_sfbanners', array('tx_phpunit'));
		$this->bannerRepository = $this->objectManager->get('Tx_SfBanners_Domain_Repository_BannerRepository');

	}

	/**
	 * Tear down
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->bannerService);
		$this->testingFramework->cleanUp();
		unset($this->testingFramework, $this->bannerRepository);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsEmptyStringIfBannerHasNoMarginsTest() {
		$result = $this->bannerService->getAdditionalCss(array());
		$this->assertEquals('', $result);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginTopIfBannerHasMarginTopTest() {
		$pid = 110;
		$bannerUid = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'margin_top' => 10));

		/* Get banner from Repository */
		$banners = $this->bannerRepository->findByPid($pid);

		$expected = '.banner-' . $bannerUid . ' { margin: 10px 0px 0px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginRightIfBannerHasMarginRightTest() {
		$pid = 110;
		$bannerUid = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'margin_right' => 10));

		/* Get banner from Repository */
		$banners = $this->bannerRepository->findByPid($pid);

		$expected = '.banner-' . $bannerUid . ' { margin: 0px 10px 0px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginBottomIfBannerHasMarginBottomTest() {
		$pid = 110;
		$bannerUid = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'margin_bottom' => 10));

		/* Get banner from Repository */
		$banners = $this->bannerRepository->findByPid($pid);

		$expected = '.banner-' . $bannerUid . ' { margin: 0px 0px 10px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginLeftIfBannerHasMarginLeftTest() {
		$pid = 110;
		$bannerUid = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'margin_left' => 10));

		/* Get banner from Repository */
		$banners = $this->bannerRepository->findByPid($pid);

		$expected = '.banner-' . $bannerUid . ' { margin: 0px 0px 0px 10px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsCssForMultipleBannersTest() {
		$pid = 111;
		$bannerUid1 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'margin_left' => 10, 'margin_right' => 10, 'sorting' => 1));
		$bannerUid2 = $this->testingFramework->createRecord('tx_sfbanners_domain_model_banner', array('pid' => $pid,
			'margin_top' => 10, 'margin_bottom' => 10, 'sorting' => 2));

		/* Get banner from Repository */
		$banners = $this->bannerRepository->findByPid($pid);

		$expected = '.banner-' . $bannerUid1 . ' { margin: 0px 10px 0px 10px; }' . chr(10) . chr(13);
		$expected .= '.banner-' . $bannerUid2 . ' { margin: 10px 0px 10px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}
}
?>
