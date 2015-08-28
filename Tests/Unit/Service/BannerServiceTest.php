<?php
namespace DERHANSEN\SfBanners\Test\Unit\Service;
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

use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use DERHANSEN\SfBanners\Service\BannerService;

/**
 * Test cases for the banner service
 */
class BannerServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \DERHANSEN\SfBanners\Service\BannerService
	 */
	protected $bannerService;

	/**
	 * @var \DERHANSEN\SfBanners\Domain\Model\BannerDemand
	 */
	protected $demand;

	/**
	 * Set up
	 *
	 * @return void
	 */
	public function setUp() {
		$this->bannerService = new BannerService();
		$this->demand = new BannerDemand();
		$this->demand->setDisplayMode('all');
	}

	/**
	 * Tear down
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->bannerService, $this->demand);
	}

	/**
	 * Test if additional css returns an empty string if banner has no margin
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsEmptyStringIfBannerHasNoMarginsTest() {
		$result = $this->bannerService->getAdditionalCss(array());
		$this->assertEquals('', $result);
	}

	/**
	 * Test if additional css returns correct top margin
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginTopIfBannerHasMarginTopTest() {
		$bannerUid = 100;
		$banner = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner->expects($this->any())->method('getMarginTop')->will($this->returnValue(10));
		$banner->expects($this->any())->method('getMarginRight')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginBottom')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginLeft')->will($this->returnValue(0));
		$banner->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid));

		/** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $banners */
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$banners->attach($banner);

		$expected = '.banner-' . $bannerUid . ' { margin: 10px 0px 0px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * Test if additional css returns correct right margin
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginRightIfBannerHasMarginRightTest() {
		$bannerUid = 100;
		$banner = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner->expects($this->any())->method('getMarginTop')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginRight')->will($this->returnValue(10));
		$banner->expects($this->any())->method('getMarginBottom')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginLeft')->will($this->returnValue(0));
		$banner->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid));

		/** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $banners */
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$banners->attach($banner);

		$expected = '.banner-' . $bannerUid . ' { margin: 0px 10px 0px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * Test if additional css returns correct bottom margin
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginBottomIfBannerHasMarginBottomTest() {
		$bannerUid = 100;
		$banner = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner->expects($this->any())->method('getMarginTop')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginRight')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginBottom')->will($this->returnValue(10));
		$banner->expects($this->any())->method('getMarginLeft')->will($this->returnValue(0));
		$banner->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid));

		/** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $banners */
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$banners->attach($banner);

		$expected = '.banner-' . $bannerUid . ' { margin: 0px 0px 10px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * Test if additional css returns correct left margin
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsMarginLeftIfBannerHasMarginLeftTest() {
		$bannerUid = 100;
		$banner = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner->expects($this->any())->method('getMarginTop')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginRight')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginBottom')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginLeft')->will($this->returnValue(10));
		$banner->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid));

		/** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $banners */
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$banners->attach($banner);

		$expected = '.banner-' . $bannerUid . ' { margin: 0px 0px 0px 10px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * Test if additional css returns correct margins for multiple banners
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssReturnsCssForMultipleBannersTest() {
		$bannerUid1 = 100;
		$bannerUid2 = 200;
		$banner1 = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner1->expects($this->any())->method('getMarginTop')->will($this->returnValue(0));
		$banner1->expects($this->any())->method('getMarginRight')->will($this->returnValue(10));
		$banner1->expects($this->any())->method('getMarginBottom')->will($this->returnValue(0));
		$banner1->expects($this->any())->method('getMarginLeft')->will($this->returnValue(10));
		$banner1->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid1));
		$banner2 = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner2->expects($this->any())->method('getMarginTop')->will($this->returnValue(10));
		$banner2->expects($this->any())->method('getMarginRight')->will($this->returnValue(0));
		$banner2->expects($this->any())->method('getMarginBottom')->will($this->returnValue(10));
		$banner2->expects($this->any())->method('getMarginLeft')->will($this->returnValue(0));
		$banner2->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid2));

		/** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $banners */
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$banners->attach($banner1);
		$banners->attach($banner2);

		$expected = '.banner-' . $bannerUid1 . ' { margin: 0px 10px 0px 10px; }' . chr(10) . chr(13);
		$expected .= '.banner-' . $bannerUid2 . ' { margin: 10px 0px 10px 0px; }' . chr(10) . chr(13);
		$result = $this->bannerService->getAdditionalCss($banners);
		$this->assertEquals($expected, $result);
	}

	/**
	 * Test if no CSS file is returned if no banners given
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssFileReturnsEmptyStringIfNoBannersFoundTest() {
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$result = $this->bannerService->getAdditionalCssFile($banners);
		$this->assertEmpty($result);
	}

	/**
	 * Test if returned file contains .css as extension
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssFileReturnsFilenameTest() {
		$bannerUid = 100;
		$banner = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner->expects($this->any())->method('getMarginTop')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginRight')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginBottom')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginLeft')->will($this->returnValue(10));
		$banner->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid));

		/** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $banners */
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$banners->attach($banner);

		$expected = '/\.css/';
		$result = $this->bannerService->getAdditionalCssFile($banners);
		$this->assertRegExp($expected, $result);
	}

	/**
	 * Test if no CSS link is returned if no banners given
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssLinkReturnsEmptyStringIfNoBannersFoundTest() {
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$result = $this->bannerService->getAdditionalCssLink($banners);
		$this->assertEmpty($result);
	}

	/**
	 * Test if no CSS link is returned if no banners given
	 *
	 * @test
	 * @return void
	 */
	public function getAdditionalCssLinkReturnsLinkTest() {
		$bannerUid = 100;
		$banner = $this->getMock('DERHANSEN\\SfBanners\\Domain\\Model\\Banner',
			array(), array(), '', FALSE);
		$banner->expects($this->any())->method('getMarginTop')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginRight')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginBottom')->will($this->returnValue(0));
		$banner->expects($this->any())->method('getMarginLeft')->will($this->returnValue(10));
		$banner->expects($this->once())->method('getUid')->will($this->returnValue($bannerUid));

		/** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $banners */
		$banners = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$banners->attach($banner);

		$result = $this->bannerService->getAdditionalCssLink($banners);
		$this->assertContains('<link rel="stylesheet" type="text/css" href=', $result);
		$this->assertContains('.css', $result);
		$this->assertContains('media="all" />', $result);
	}
}