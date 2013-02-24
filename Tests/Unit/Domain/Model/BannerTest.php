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
 * Test case for class Tx_SfBanners_Domain_Model_Banner.
 */
class Tx_SfBanners_Domain_Model_BannerTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_SfBanners_Domain_Model_Banner
	 */
	protected $fixture;

	/**
	 * Set up
	 *
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new Tx_SfBanners_Domain_Model_Banner();
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
	 * Test if title can be set
	 *
	 * @test
	 * @return void
	 */
	public function titleCanBeSetTest() {
		$title = 'a title';
		$this->fixture->setTitle($title);
		$this->assertEquals($title, $this->fixture->getTitle());
	}


	/**
	 * Test if description can be set
	 *
	 * @test
	 * @return void
	 */
	public function descriptionCanBeSetTest() {
		$description = 'a description';
		$this->fixture->setDescription($description);
		$this->assertEquals($description, $this->fixture->getDescription());
	}

	/**
	 * Test if type can be set
	 *
	 * @test
	 * @return void
	 */
	public function typeCanBeSetTest() {
		$type = 0;
		$this->fixture->setType($type);
		$this->assertEquals($type, $this->fixture->getType());
	}

	/**
	 * Test if image can be set
	 *
	 * @test
	 * @return void
	 */
	public function imageCanBeSetTest() {
		$image = 'image.jpg';
		$this->fixture->setImage($image);
		$this->assertEquals($image, $this->fixture->getImage());
	}

	/**
	 * Test if margin can be set
	 *
	 * @test
	 * @return void
	 */
	public function marginTopCanBeSetTest() {
		$margin = 100;
		$this->fixture->setMarginTop($margin);
		$this->assertEquals($margin, $this->fixture->getMarginTop());
	}

	/**
	 * Test if margin can be set
	 *
	 * @test
	 * @return void
	 */
	public function marginRightCanBeSetTest() {
		$margin = 100;
		$this->fixture->setMarginRight($margin);
		$this->assertEquals($margin, $this->fixture->getMarginRight());
	}

	/**
	 * Test if margin can be set
	 *
	 * @test
	 * @return void
	 */
	public function marginBottomCanBeSetTest() {
		$margin = 100;
		$this->fixture->setMarginBottom($margin);
		$this->assertEquals($margin, $this->fixture->getMarginBottom());
	}

	/**
	 * Test if margin can be set
	 *
	 * @test
	 * @return void
	 */
	public function marginLeftCanBeSetTest() {
		$margin = 100;
		$this->fixture->setMarginLeft($margin);
		$this->assertEquals($margin, $this->fixture->getMarginLeft());
	}

	/**
	 * Test if alttext can be set
	 *
	 * @test
	 * @return void
	 */
	public function altTextCanBeSetTest() {
		$altText = 'some text';
		$this->fixture->setAlttext($altText);
		$this->assertEquals($altText, $this->fixture->getAlttext());
	}

	/**
	 * Test if link can be set
	 *
	 * @test
	 * @return void
	 */
	public function linkCanBeSetTest() {
		$link = 'www.domain.tld';
		$this->fixture->setLink($link);
		$this->assertEquals($link, $this->fixture->getLink());
	}

	/**
	 * Test if html can be set
	 *
	 * @test
	 * @return void
	 */
	public function htmlCanBeSetTest() {
		$html = '<p>test</p>';
		$this->fixture->setHtml($html);
		$this->assertEquals($html, $this->fixture->getHtml());
	}

	/**
	 * Test if flash can be set
	 *
	 * @test
	 * @return void
	 */
	public function flashCanBeSetTest() {
		$flash = 'flash.swf';
		$this->fixture->setFlash($flash);
		$this->assertEquals($flash, $this->fixture->getFlash());
	}

	/**
	 * Test if flashwidth can be set
	 *
	 * @test
	 * @return void
	 */
	public function flashWidthCanBeSetTest() {
		$width = 100;
		$this->fixture->setFlashWidth($width);
		$this->assertEquals($width, $this->fixture->getFlashWidth());
	}

	/**
	 * Test if flshheight can be set
	 *
	 * @test
	 * @return void
	 */
	public function flashHeighCanBeSetTest() {
		$height = 100;
		$this->fixture->setFlashHeight($height);
		$this->assertEquals($height, $this->fixture->getFlashHeight());
	}

	/**
	 * Test if impressionsmax can be set
	 *
	 * @test
	 * @return void
	 */
	public function impressionsMaxCanBeSetTest() {
		$impressionsMax = 100;
		$this->fixture->setImpressionsMax($impressionsMax);
		$this->assertEquals($impressionsMax, $this->fixture->getImpressionsMax());
	}

	/**
	 * Test if clicksmax can be set
	 *
	 * @test
	 * @return void
	 */
	public function clicksMaxCanBeSetTest() {
		$clicksMax = 100;
		$this->fixture->setClicksMax($clicksMax);
		$this->assertEquals($clicksMax, $this->fixture->getClicksMax());
	}

	/**
	 * Test if impressions can be set
	 *
	 * @test
	 * @return void
	 */
	public function impressionsCanBeSetTest() {
		$impressions = 100;
		$this->fixture->setImpressions($impressions);
		$this->assertEquals($impressions, $this->fixture->getImpressions());
	}

	/**
	 * Test if clicks can be set
	 *
	 * @test
	 * @return void
	 */
	public function clicksCanBeSetTest() {
		$clicks = 100;
		$this->fixture->setClicks($clicks);
		$this->assertEquals($clicks, $this->fixture->getClicks());
	}

	/**
	 * Test if allowscriptaccess can be set
	 *
	 * @test
	 * @return void
	 */
	public function flashAllowScriptAccessCanBeSetTest() {
		$flashAllowScriptAccess = 'sameDomain';
		$this->fixture->setflashAllowScriptAccess($flashAllowScriptAccess);
		$this->assertEquals($flashAllowScriptAccess, $this->fixture->getflashAllowScriptAccess());
	}

	/**
	 * Test if wmode can be set
	 *
	 * @test
	 * @return void
	 */
	public function flashWmodeCanBeSetTest() {
		$flashWmode = 'opaque';
		$this->fixture->setFlashWmode($flashWmode);
		$this->assertEquals($flashWmode, $this->fixture->getFlashWmode());
	}

}
?>