<?php
namespace DERHANSEN\SfBanners\Test\Unit\Domain\Model;
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

use TYPO3\CMS\Core\Tests\UnitTestCase;
use DERHANSEN\SfBanners\Domain\Model\Category;

/**
 * Test case for class \DERHANSEN\SfBanners\Domain\Model\Category
 */
class CategoryTest extends UnitTestCase {
	/**
	 * @var \DERHANSEN\SfBanners\Domain\Model\Category
	 */
	protected $fixture;

	/**
	 * Set up
	 *
	 * @return void
	 */
	public function setUp() {
		$this->fixture = new Category();
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
	 * Test if parent can be set
	 *
	 * @test
	 * @return void
	 */
	public function parentCanBeSetTest() {
		$parent = new \DERHANSEN\SfBanners\Domain\Model\Category();
		$this->fixture->setParent($parent);
		$this->assertEquals($parent, $this->fixture->getParent());
	}
}