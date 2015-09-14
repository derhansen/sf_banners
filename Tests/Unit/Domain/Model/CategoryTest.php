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