<?php
namespace DERHANSEN\SfBanners\Domain\Model;

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Banner domain model
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class Banner extends AbstractEntity
{
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
     * @var int
     * @validate NotEmpty
     */
    protected $type;

    /**
     * Category
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     * @lazy
     */
    protected $category;

    /**
     * Fal media items
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $assets;

    /**
     * Margin top
     *
     * @var int
     */
    protected $marginTop;

    /**
     * Margin right
     *
     * @var int
     */
    protected $marginRight;

    /**
     * Margin bottom
     *
     * @var int
     */
    protected $marginBottom;

    /**
     * Margin top
     *
     * @var int
     */
    protected $marginLeft;

    /**
     * Alttext
     *
     * @var string
     */
    protected $alttext;

    /**
     * HTML
     *
     * @var string
     */
    protected $html;

    /**
     * Max impressions
     *
     * @var int
     */
    protected $impressionsMax;

    /**
     * Max clicks
     *
     * @var int
     */
    protected $clicksMax;

    /**
     * Total impressions
     *
     * @var int
     */
    protected $impressions;

    /**
     * Total clicks
     *
     * @var int
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
     * __construct
     */
    public function __construct()
    {
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
    protected function initStorageObjects()
    {
        $this->category = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->excludepages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assets = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title The title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description The description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the type
     *
     * @return int $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param int $type The type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Adds a category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category)
    {
        $this->category->attach($category);
    }

    /**
     * Removes a category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove
     * @return void
     */
    public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove)
    {
        $this->category->detach($categoryToRemove);
    }

    /**
     * Returns the category
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $category One or multiple categories
     * @return void
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Setter for alttext
     *
     * @param string $alttext Alttext
     * @return void
     */
    public function setAlttext($alttext)
    {
        $this->alttext = $alttext;
    }

    /**
     * Getter for alttext
     *
     * @return string
     */
    public function getAlttext()
    {
        return $this->alttext;
    }

    /**
     * Setter for clicks
     *
     * @param int $clicks Clicks
     * @return void
     */
    public function setClicks($clicks)
    {
        $this->clicks = $clicks;
    }

    /**
     * getter for clicks
     *
     * @return int
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Setter for clicksmax
     *
     * @param int $clicksMax MaxClicks
     * @return void
     */
    public function setClicksMax($clicksMax)
    {
        $this->clicksMax = $clicksMax;
    }

    /**
     * Getter for clicksmax
     *
     * @return int
     */
    public function getClicksMax()
    {
        return $this->clicksMax;
    }

    /**
     * Adds a page
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\Page $page
     * @return void
     */
    public function addExcludepages(\DERHANSEN\SfBanners\Domain\Model\Page $page)
    {
        $this->excludepages->attach($page);
    }

    /**
     * Removes a page
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\page $pageToRemove
     * @return void
     */
    public function removeExcludepages(\DERHANSEN\SfBanners\Domain\Model\page $pageToRemove)
    {
        $this->excludepages->detach($pageToRemove);
    }

    /**
     * Setter for excludepages
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $excludepages Excludepages
     * @return void
     */
    public function setExcludepages($excludepages)
    {
        $this->excludepages = $excludepages;
    }

    /**
     * Getter for excludepages
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getExcludepages()
    {
        return $this->excludepages;
    }

    /**
     * Setter for HTML
     *
     * @param string $html HTML
     * @return void
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * Getter for HTML
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Setter for impressions
     *
     * @param int $impressions Impressions
     * @return void
     */
    public function setImpressions($impressions)
    {
        $this->impressions = $impressions;
    }

    /**
     * Getter for impressions
     *
     * @return int
     */
    public function getImpressions()
    {
        return $this->impressions;
    }

    /**
     * Setter for max impressions
     *
     * @param int $impressionsMax Max impressions
     * @return void
     */
    public function setImpressionsMax($impressionsMax)
    {
        $this->impressionsMax = $impressionsMax;
    }

    /**
     * Getter for max impressions
     *
     * @return int
     */
    public function getImpressionsMax()
    {
        return $this->impressionsMax;
    }

    /**
     * Getter for link
     *
     * @return string
     */
    public function getLink()
    {
        $this->assets->rewind();

        /** @var \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference */
        $fileReference = $this->assets->current();

        if ($fileReference === null) {
            return '';
        }

        /** @var \TYPO3\CMS\Core\Resource\FileReference $originalFileReference */
        $originalFileReference = $fileReference->getOriginalResource();
        return $originalFileReference->getLink();
    }

    /**
     * Setter for margin bottom
     *
     * @param int $marginBottom Margin bottom
     * @return void
     */
    public function setMarginBottom($marginBottom)
    {
        $this->marginBottom = $marginBottom;
    }

    /**
     * Getter for margin bottom
     *
     * @return int
     */
    public function getMarginBottom()
    {
        return $this->marginBottom;
    }

    /**
     * Setter for margin left
     *
     * @param int $marginLeft Margin left
     * @return void
     */
    public function setMarginLeft($marginLeft)
    {
        $this->marginLeft = $marginLeft;
    }

    /**
     * Getter for margin left
     *
     * @return int
     */
    public function getMarginLeft()
    {
        return $this->marginLeft;
    }

    /**
     * Setter for margin right
     *
     * @param int $marginRight Margin right
     * @return void
     */
    public function setMarginRight($marginRight)
    {
        $this->marginRight = $marginRight;
    }

    /**
     * Getter for margin right
     *
     * @return int
     */
    public function getMarginRight()
    {
        return $this->marginRight;
    }

    /**
     * Setter for margin top
     *
     * @param int $marginTop Margin top
     * @return void
     */
    public function setMarginTop($marginTop)
    {
        $this->marginTop = $marginTop;
    }

    /**
     * Getter for margin top
     *
     * @return int
     */
    public function getMarginTop()
    {
        return $this->marginTop;
    }

    /**
     * Sets the recursive flag
     *
     * @param bool $recursive
     * @return void
     */
    public function setRecursive($recursive)
    {
        $this->recursive = $recursive;
    }

    /**
     * Returns the recursive flag
     *
     * @return bool
     */
    public function getRecursive()
    {
        return $this->recursive;
    }

    /**
     * Updates the Impressions by 1
     *
     * @return void
     */
    public function increaseImpressions()
    {
        $this->impressions += 1;
    }

    /**
     * Updates the Impressions by 1
     *
     * @return void
     */
    public function increaseClicks()
    {
        $this->clicks += 1;
    }

    /**
     * Returns the uri of the link
     *
     * @return mixed
     */
    public function getLinkUrl()
    {
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        return $cObj->getTypoLink_URL($this->getLink());
    }

    /**
     * Returns the target of the link
     *
     * @return string
     */
    public function getLinkTarget()
    {
        $link = $this->getLink();
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $cObj->getTypoLink_URL($link);
        return $cObj->lastTypoLinkTarget;
    }

    /**
     * Get the Fal media items
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Set Fal media relation
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $assets
     * @return void
     */
    public function setAssets(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $assets)
    {
        $this->assets = $assets;
    }

    /**
     * Add a Fal media file reference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $asset
     */
    public function addAsset(\TYPO3\CMS\Extbase\Domain\Model\FileReference $asset)
    {
        $this->assets->attach($asset);
    }

    /**
     * Remove a Fal media file reference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $asset
     */
    public function removeAsset(\TYPO3\CMS\Extbase\Domain\Model\FileReference $asset)
    {
        $this->assets->detach($asset);
    }
}
