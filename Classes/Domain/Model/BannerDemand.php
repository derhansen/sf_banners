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
 */
class Tx_SfBanners_Domain_Model_BannerDemand extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Categories
	 *
	 * @var string
	 */
	protected $categories;

	/**
	 * Startingpoint(s)
	 *
	 * @var string
	 */
	protected $startingPoint;

	/**
	 * Display Mode - default is to display all banners
	 *
	 * @var string
	 */
	protected $displayMode = 'all';

	/**
	 * The current page uid
	 *
	 * @var integer
	 */
	protected $currentPageUid;

	/**
	 * Setter for currentPageUid
	 *
	 * @param string $categories The categories
	 * @return void
	 */
	public function setCategories ($categories) {
		$this->categories = $categories;
	}

	/**
	 * Getter for categories
	 *
	 * @return string
	 */
	public function getCategories () {
		return $this->categories;
	}

	/**
	 * Setter for currentPageUid
	 *
	 * @param int $currentPageUid Current Page UID
	 * @return void
	 */
	public function setCurrentPageUid ($currentPageUid) {
		$this->currentPageUid = $currentPageUid;
	}

	/**
	 * Getter for currentPageUid
	 *
	 * @return int
	 */
	public function getCurrentPageUid () {
		return $this->currentPageUid;
	}

	/**
	 * Setter for startingPoint
	 *
	 * @param string $displayMode Displaymode
	 * @return void
	 */
	public function setDisplayMode ($displayMode) {
		$this->displayMode = $displayMode;
	}

	/**
	 * Getter for displayMode
	 *
	 * @return string
	 */
	public function getDisplayMode () {
		return $this->displayMode;
	}

	/**
	 * Setter for startingPoint
	 *
	 * @param string $startingPoint Startingpoint(s)
	 * @return void
	 */
	public function setStartingPoint ($startingPoint) {
		$this->startingPoint = $startingPoint;
	}

	/**
	 * Getter for startingPoint
	 *
	 * @return string
	 */
	public function getStartingPoint () {
		return $this->startingPoint;
	}

}
?>