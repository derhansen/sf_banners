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
 * Banner demand
 *
 * @package sf_banners
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_SfBanners_Domain_Model_BannerDemand extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Categories
	 *
	 * @var string
	 */
	protected $categories;

	/**
	 * Storage page(s)
	 *
	 * @var string
	 */
	protected $storagePage;

	/**
	 * Display Mode
	 *
	 * @var integer
	 */
	protected $displayMode;

	/**
	 * The current page uid
	 *
	 * @var integer
	 */
	protected $currentPageUid;

	/**
	 * @param string $categories
	 */
	public function setCategories ($categories) {
		$this->categories = $categories;
	}

	/**
	 * @return string
	 */
	public function getCategories () {
		return $this->categories;
	}

	/**
	 * @param int $currentPageUid
	 */
	public function setCurrentPageUid ($currentPageUid) {
		$this->currentPageUid = $currentPageUid;
	}

	/**
	 * @return int
	 */
	public function getCurrentPageUid () {
		return $this->currentPageUid;
	}

	/**
	 * @param int $displayMode
	 */
	public function setDisplayMode ($displayMode) {
		$this->displayMode = $displayMode;
	}

	/**
	 * @return int
	 */
	public function getDisplayMode () {
		return $this->displayMode;
	}

	/**
	 * @param string $storagePage
	 */
	public function setStoragePage ($storagePage) {
		$this->storagePage = $storagePage;
	}

	/**
	 * @return string
	 */
	public function getStoragePage () {
		return $this->storagePage;
	}

}
?>
