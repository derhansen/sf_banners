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
 *
 * @package sf_banners
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_SfBanners_Domain_Model_Banner extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Type
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $type;

	/**
	 * Category
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SfBanners_Domain_Model_Category>
	 */
	protected $category;

	/**
	 * Image
	 *
	 * @var string
	 */
	protected $image;

	/**
	 * Margin top
	 *
	 * @var integer
	 */
	protected $margin_top;

	/**
	 * Margin right
	 *
	 * @var integer
	 */
	protected $margin_right;

	/**
	 * Margin bottom
	 *
	 * @var integer
	 */
	protected $margin_bottom;

	/**
	 * Margin top
	 *
	 * @var integer
	 */
	protected $margin_left;

	/**
	 * Alttext
	 *
	 * @var string
	 */
	protected $alttext;

	/**
	 * Link
	 *
	 * @var string
	 */
	protected $link;

	/**
	 * HTML
	 *
	 * @var string
	 */
	protected $html;

	/**
	 * Flash
	 *
	 * @var string
	 */
	protected $flash;

	/**
	 * Flash width
	 *
	 * @var integer
	 */
	protected $flash_width;

	/**
	 * Flash height
	 *
	 * @var integer
	 */
	protected $flash_height;

	/**
	 * Max impressions
	 *
	 * @var integer
	 */
	protected $impressions_max;

	/**
	 * Max clicks
	 *
	 * @var integer
	 */
	protected $clicks_max;

	/**
	 * Totel impressions
	 *
	 * @var integer
	 */
	protected $impressions;

	/**
	 * Total clicks
	 *
	 * @var integer
	 */
	protected $clicks;

	/**
	 * Display on pages
	 *
	 * @var string
	 */
	protected $pages;

	/**
	 * Do not display on pages
	 *
	 * @var string
	 */
	protected $excludepages;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the type
	 *
	 * @return integer $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets the type
	 *
	 * @param integer $type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the category
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SfBanners_Domain_Model_Category> $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage $category
	 * @return void
	 */
	public function setCategory($category) {
		$this->category = $category;
	}

	/**
	 * @param string $alttext
	 */
	public function setAlttext ($alttext) {
		$this->alttext = $alttext;
	}

	/**
	 * @return string
	 */
	public function getAlttext () {
		return $this->alttext;
	}

	/**
	 * @param int $clicks
	 */
	public function setClicks ($clicks) {
		$this->clicks = $clicks;
	}

	/**
	 * @return int
	 */
	public function getClicks () {
		return $this->clicks;
	}

	/**
	 * @param int $clicks_max
	 */
	public function setClicksMax ($clicks_max) {
		$this->clicks_max = $clicks_max;
	}

	/**
	 * @return int
	 */
	public function getClicksMax () {
		return $this->clicks_max;
	}

	/**
	 * @param string $excludepages
	 */
	public function setExcludepages ($excludepages) {
		$this->excludepages = $excludepages;
	}

	/**
	 * @return string
	 */
	public function getExcludepages () {
		return $this->excludepages;
	}

	/**
	 * @param string $flash
	 */
	public function setFlash ($flash) {
		$this->flash = $flash;
	}

	/**
	 * @return string
	 */
	public function getFlash () {
		return $this->flash;
	}

	/**
	 * @param int $flash_height
	 */
	public function setFlashHeight ($flash_height) {
		$this->flash_height = $flash_height;
	}

	/**
	 * @return int
	 */
	public function getFlashHeight () {
		return $this->flash_height;
	}

	/**
	 * @param int $flash_width
	 */
	public function setFlashWidth ($flash_width) {
		$this->flash_width = $flash_width;
	}

	/**
	 * @return int
	 */
	public function getFlashWidth () {
		return $this->flash_width;
	}

	/**
	 * @param string $html
	 */
	public function setHtml ($html) {
		$this->html = $html;
	}

	/**
	 * @return string
	 */
	public function getHtml () {
		return $this->html;
	}

	/**
	 * @param string $image
	 */
	public function setImage ($image) {
		$this->image = $image;
	}

	/**
	 * @return string
	 */
	public function getImage () {
		return $this->image;
	}

	/**
	 * @param int $impressions
	 */
	public function setImpressions ($impressions) {
		$this->impressions = $impressions;
	}

	/**
	 * @return int
	 */
	public function getImpressions () {
		return $this->impressions;
	}

	/**
	 * @param int $impressions_max
	 */
	public function setImpressionsMax ($impressions_max) {
		$this->impressions_max = $impressions_max;
	}

	/**
	 * @return int
	 */
	public function getImpressionsMax () {
		return $this->impressions_max;
	}

	/**
	 * @param string $link
	 */
	public function setLink ($link) {
		$this->link = $link;
	}

	/**
	 * @return string
	 */
	public function getLink () {
		return $this->link;
	}

	/**
	 * @param int $margin_bottom
	 */
	public function setMarginBottom ($margin_bottom) {
		$this->margin_bottom = $margin_bottom;
	}

	/**
	 * @return int
	 */
	public function getMarginBottom () {
		return $this->margin_bottom;
	}

	/**
	 * @param int $margin_left
	 */
	public function setMarginLeft ($margin_left) {
		$this->margin_left = $margin_left;
	}

	/**
	 * @return int
	 */
	public function getMarginLeft () {
		return $this->margin_left;
	}

	/**
	 * @param int $margin_right
	 */
	public function setMarginRight ($margin_right) {
		$this->margin_right = $margin_right;
	}

	/**
	 * @return int
	 */
	public function getMarginRight () {
		return $this->margin_right;
	}

	/**
	 * @param int $margin_top
	 */
	public function setMarginTop ($margin_top) {
		$this->margin_top = $margin_top;
	}

	/**
	 * @return int
	 */
	public function getMarginTop () {
		return $this->margin_top;
	}

	/**
	 * @param string $pages
	 */
	public function setPages ($pages) {
		$this->pages = $pages;
	}

	/**
	 * @return string
	 */
	public function getPages () {
		return $this->pages;
	}


}
?>