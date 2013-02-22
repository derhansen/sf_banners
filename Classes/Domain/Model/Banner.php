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
	 * Total impressions
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
	 * AllowScriptAccess for flash banners
	 *
	 * @var string
	 */
	protected $flashAllowScriptAccess;

	/**
	 * Wmode for flash banners
	 *
	 * @var string
	 */
	protected $flashWmode;

	/**
	 * Sets allowScriptAccess
	 *
	 * @param string $flashAllowScriptAccess
	 * @return void
	 */
	public function setFlashAllowScriptAccess ($flashAllowScriptAccess) {
		$this->flashAllowScriptAccess = $flashAllowScriptAccess;
	}

	/**
	 * Getter for allowScriptAccess
	 *
	 * @return string
	 * @return void
	 */
	public function getFlashAllowScriptAccess () {
		return $this->flashAllowScriptAccess;
	}

	/**
	 * Sets Wmode
	 *
	 * @param string $flashWmode
	 * @return void
	 */
	public function setFlashWmode ($flashWmode) {
		$this->flashWmode = $flashWmode;
	}

	/**
	 * Getter for Wmode
	 *
	 * @return string
	 */
	public function getFlashWmode () {
		return $this->flashWmode;
	}

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
	 * Setter for alttext
	 *
	 * @param string $alttext
	 * @return void
	 */
	public function setAlttext ($alttext) {
		$this->alttext = $alttext;
	}

	/**
	 * @return string
	 * @return void
	 */
	public function getAlttext () {
		return $this->alttext;
	}

	/**
	 * @param int $clicks
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 * @return void
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
	 *
	 * @return void
	 */
	public function increaseImpressions() {
		$this->impressions += 1;
	}

	/**
	 * Updates the Impressions by 1
	 *
	 * @return void
	 */
	public function increaseClicks() {
		$this->clicks += 1;
	}

	/**
	 * Returns the uri of the link
	 *
	 * @return mixed
	 */
	public function getLinkUrl() {
		$cObj = t3lib_div::makeInstance('tslib_cObj');
		return $cObj->getTypoLink_URL($this->link);
	}

	/**
	 * Returns the target of the link
	 *
	 * @return string
	 */
	public function getLinkTarget() {
		$linkArray = t3lib_div::trimExplode(' ', $this->link);
		$ret = '';
		if (count($linkArray) > 1) {
			$ret = $linkArray[1];
		}
		return $ret;
	}
}
?>