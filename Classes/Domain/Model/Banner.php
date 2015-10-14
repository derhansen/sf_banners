<?php
namespace DERHANSEN\SfBanners\Domain\Model;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Banner domain model
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class Banner extends AbstractEntity {

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
	 * @lazy
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DERHANSEN\SfBanners\Domain\Model\Category>
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
	 * @lazy
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DERHANSEN\SfBanners\Domain\Model\Page>
	 */
	protected $excludepages;

	/**
	 * Recursively use excludepages
	 * @var bool
	 */
	protected $recursive;

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
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->category = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->excludepages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Sets allowScriptAccess
	 *
	 * @param string $flashAllowScriptAccess FlashAllowScriptAccess
	 * @return void
	 */
	public function setFlashAllowScriptAccess ($flashAllowScriptAccess) {
		$this->flashAllowScriptAccess = $flashAllowScriptAccess;
	}

	/**
	 * Getter for allowScriptAccess
	 *
	 * @return string
	 */
	public function getFlashAllowScriptAccess () {
		return $this->flashAllowScriptAccess;
	}

	/**
	 * Sets Wmode
	 *
	 * @param string $flashWmode FlashWMode
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
	 * @param string $title The title
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
	 * @param string $description The description
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
	 * @param integer $type The type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Adds a category
	 *
	 * @param \DERHANSEN\SfBanners\Domain\Model\Category $category
	 * @return void
	 */
	public function addCategory(\DERHANSEN\SfBanners\Domain\Model\Category $category) {
		$this->category->attach($category);
	}

	/**
	 * Removes a category
	 *
	 * @param \DERHANSEN\SfBanners\Domain\Model\Category $categoryToRemove
	 * @return void
	 */
	public function removeCategory(\DERHANSEN\SfBanners\Domain\Model\Category $categoryToRemove) {
		$this->category->detach($categoryToRemove);
	}

	/**
	 * Returns the category
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $category One or multiple categories
	 * @return void
	 */
	public function setCategory($category) {
		$this->category = $category;
	}

	/**
	 * Setter for alttext
	 *
	 * @param string $alttext Alttext
	 * @return void
	 */
	public function setAlttext ($alttext) {
		$this->alttext = $alttext;
	}

	/**
	 * Getter for alttext
	 *
	 * @return string
	 */
	public function getAlttext () {
		return $this->alttext;
	}

	/**
	 * Setter for clicks
	 *
	 * @param int $clicks Clicks
	 * @return void
	 */
	public function setClicks ($clicks) {
		$this->clicks = $clicks;
	}

	/**
	 * getter for clicks
	 *
	 * @return int
	 */
	public function getClicks () {
		return $this->clicks;
	}

	/**
	 * Setter for clicksmax
	 *
	 * @param int $clicksMax MaxClicks
	 * @return void
	 */
	public function setClicksMax ($clicksMax) {
		$this->clicksMax = $clicksMax;
	}

	/**
	 * Getter for clicksmax
	 *
	 * @return int
	 */
	public function getClicksMax () {
		return $this->clicksMax;
	}

	/**
	 * Adds a page
	 *
	 * @param \DERHANSEN\SfBanners\Domain\Model\Page $page
	 * @return void
	 */
	public function addExcludepages(\DERHANSEN\SfBanners\Domain\Model\Page $page) {
		$this->excludepages->attach($page);
	}

	/**
	 * Removes a page
	 *
	 * @param \DERHANSEN\SfBanners\Domain\Model\page $pageToRemove
	 * @return void
	 */
	public function removeExcludepages(\DERHANSEN\SfBanners\Domain\Model\page $pageToRemove) {
		$this->excludepages->detach($pageToRemove);
	}

	/**
	 * Setter for excludepages
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $excludepages Excludepages
	 * @return void
	 */
	public function setExcludepages ($excludepages) {
		$this->excludepages = $excludepages;
	}

	/**
	 * Getter for excludepages
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getExcludepages () {
		return $this->excludepages;
	}

	/**
	 * Setter for flash
	 *
	 * @param string $flash Flashfile
	 * @return void
	 */
	public function setFlash ($flash) {
		$this->flash = $flash;
	}

	/**
	 * Getter for flash
	 *
	 * @return string
	 */
	public function getFlash () {
		return $this->flash;
	}

	/**
	 * Setter for flashheight
	 *
	 * @param int $flashHeight Flashheight
	 * @return void
	 */
	public function setFlashHeight ($flashHeight) {
		$this->flashHeight = $flashHeight;
	}

	/**
	 * Getter for flash
	 *
	 * @return int
	 */
	public function getFlashHeight () {
		return $this->flashHeight;
	}

	/**
	 * Setter for flashwidth
	 *
	 * @param int $flashWidth Flashwidth
	 * @return void
	 */
	public function setFlashWidth ($flashWidth) {
		$this->flashWidth = $flashWidth;
	}

	/**
	 * Getter for flashwidth
	 *
	 * @return int
	 */
	public function getFlashWidth () {
		return $this->flashWidth;
	}

	/**
	 * Setter for HTML
	 *
	 * @param string $html HTML
	 * @return void
	 */
	public function setHtml ($html) {
		$this->html = $html;
	}

	/**
	 * Getter for HTML
	 *
	 * @return string
	 */
	public function getHtml () {
		return $this->html;
	}

	/**
	 * Setter for Image
	 *
	 * @param string $image Image
	 * @return void
	 */
	public function setImage ($image) {
		$this->image = $image;
	}

	/**
	 * Getter for image
	 *
	 * @return string
	 */
	public function getImage () {
		return $this->image;
	}

	/**
	 * Setter for impressions
	 *
	 * @param int $impressions Impressions
	 * @return void
	 */
	public function setImpressions ($impressions) {
		$this->impressions = $impressions;
	}

	/**
	 * Getter for impressions
	 *
	 * @return int
	 */
	public function getImpressions () {
		return $this->impressions;
	}

	/**
	 * Setter for max impressions
	 *
	 * @param int $impressionsMax Max impressions
	 * @return void
	 */
	public function setImpressionsMax ($impressionsMax) {
		$this->impressionsMax = $impressionsMax;
	}

	/**
	 * Getter for max impressions
	 *
	 * @return int
	 */
	public function getImpressionsMax () {
		return $this->impressionsMax;
	}

	/**
	 * Setter for link
	 *
	 * @param string $link Link
	 * @return void
	 */
	public function setLink ($link) {
		$this->link = $link;
	}

	/**
	 * Getter for link
	 *
	 * @return string
	 */
	public function getLink () {
		return $this->link;
	}

	/**
	 * Setter for margin bottom
	 *
	 * @param int $marginBottom Margin bottom
	 * @return void
	 */
	public function setMarginBottom ($marginBottom) {
		$this->marginBottom = $marginBottom;
	}

	/**
	 * Getter for margin bottom
	 *
	 * @return int
	 */
	public function getMarginBottom () {
		return $this->marginBottom;
	}

	/**
	 * Setter for margin left
	 *
	 * @param int $marginLeft Margin left
	 * @return void
	 */
	public function setMarginLeft ($marginLeft) {
		$this->marginLeft = $marginLeft;
	}

	/**
	 * Getter for margin left
	 *
	 * @return int
	 */
	public function getMarginLeft () {
		return $this->marginLeft;
	}

	/**
	 * Setter for margin right
	 *
	 * @param int $marginRight Margin right
	 * @return void
	 */
	public function setMarginRight ($marginRight) {
		$this->marginRight = $marginRight;
	}

	/**
	 * Getter for margin right
	 *
	 * @return int
	 */
	public function getMarginRight () {
		return $this->marginRight;
	}

	/**
	 * Setter for margin top
	 *
	 * @param int $marginTop Margin top
	 * @return void
	 */
	public function setMarginTop ($marginTop) {
		$this->marginTop = $marginTop;
	}

	/**
	 * Getter for margin top
	 *
	 * @return int
	 */
	public function getMarginTop () {
		return $this->marginTop;
	}

	/**
	 * Sets the recursive flag
	 *
	 * @param boolean $recursive
	 * @return void
	 */
	public function setRecursive ($recursive) {
		$this->recursive = $recursive;
	}

	/**
	 * Returns the recursive flag
	 *
	 * @return boolean
	 */
	public function getRecursive () {
		return $this->recursive;
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
		$cObj = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
		return $cObj->getTypoLink_URL($this->link);
	}

	/**
	 * Returns the target of the link
	 *
	 * @return string
	 */
	public function getLinkTarget() {
		$linkArray = GeneralUtility::trimExplode(' ', $this->link);
		$ret = '';
		if (count($linkArray) > 1) {
			$ret = $linkArray[1];
		}
		return $ret;
	}
}
