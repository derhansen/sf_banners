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
 * Banner domain model
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
	protected $marginTop;

	/**
	 * Margin right
	 *
	 * @var integer
	 */
	protected $marginRight;

	/**
	 * Margin bottom
	 *
	 * @var integer
	 */
	protected $marginBottom;

	/**
	 * Margin top
	 *
	 * @var integer
	 */
	protected $marginLeft;

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
	protected $flashWidth;

	/**
	 * Flash height
	 *
	 * @var integer
	 */
	protected $flashHeight;

	/**
	 * Max impressions
	 *
	 * @var integer
	 */
	protected $impressionsMax;

	/**
	 * Max clicks
	 *
	 * @var integer
	 */
	protected $clicksMax;

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
	 * Do not display on pages
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_SfBanners_Domain_Model_Page>
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
	 * @param int $clicksMax
	 */
	public function setClicksMax ($clicksMax) {
		$this->clicksMax = $clicksMax;
	}

	/**
	 * @return int
	 */
	public function getClicksMax () {
		return $this->clicksMax;
	}

	/**
	 * @param Tx_Extbase_Persistence_ObjectStorage $excludepages
	 */
	public function setExcludepages ($excludepages) {
		$this->excludepages = $excludepages;
	}

	/**
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_SfBanners_Domain_Model_Page>
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
	 * @param int $flashHeight
	 */
	public function setFlashHeight ($flashHeight) {
		$this->flashHeight = $flashHeight;
	}

	/**
	 * @return int
	 */
	public function getFlashHeight () {
		return $this->flashHeight;
	}

	/**
	 * @param int $flashWidth
	 */
	public function setFlashWidth ($flashWidth) {
		$this->flashWidth = $flashWidth;
	}

	/**
	 * @return int
	 */
	public function getFlashWidth () {
		return $this->flashWidth;
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
	 * @param int $impressionsMax
	 */
	public function setImpressionsMax ($impressionsMax) {
		$this->impressionsMax = $impressionsMax;
	}

	/**
	 * @return int
	 */
	public function getImpressionsMax () {
		return $this->impressionsMax;
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
	 * @param int $marginBottom
	 */
	public function setMarginBottom ($marginBottom) {
		$this->marginBottom = $marginBottom;
	}

	/**
	 * @return int
	 */
	public function getMarginBottom () {
		return $this->marginBottom;
	}

	/**
	 * @param int $marginLeft
	 */
	public function setMarginLeft ($marginLeft) {
		$this->marginLeft = $marginLeft;
	}

	/**
	 * @return int
	 */
	public function getMarginLeft () {
		return $this->marginLeft;
	}

	/**
	 * @param int $marginRight
	 */
	public function setMarginRight ($marginRight) {
		$this->marginRight = $marginRight;
	}

	/**
	 * @return int
	 */
	public function getMarginRight () {
		return $this->marginRight;
	}

	/**
	 * @param int $marginTop
	 */
	public function setMarginTop ($marginTop) {
		$this->marginTop = $marginTop;
	}

	/**
	 * @return int
	 */
	public function getMarginTop () {
		return $this->marginTop;
	}

	/**
	 * Updates the Impressions by 1
	 */
	public function increaseImpressions() {
		$this->impressions += 1;
	}

	/**
	 * Updates the Impressions by 1
	 */
	public function increaseClicks() {
		$this->clicks += 1;
	}

}
?>