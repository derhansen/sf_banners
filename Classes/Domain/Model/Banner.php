<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Banner domain model
 */
class Banner extends AbstractEntity
{
    /**
     * Title
     *
     * @var string
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
     */
    protected $type;

    /**
     * Category
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     * @Extbase\ORM\Lazy
     */
    protected $category;

    /**
     * Fal media items
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $assets;

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
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DERHANSEN\SfBanners\Domain\Model\Page>
     * @Extbase\ORM\Lazy
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
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Adds a category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category)
    {
        $this->category->attach($category);
    }

    /**
     * Removes a category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove
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
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Setter for clicks
     *
     * @param int $clicks Clicks
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
     */
    public function addExcludepages(\DERHANSEN\SfBanners\Domain\Model\Page $page)
    {
        $this->excludepages->attach($page);
    }

    /**
     * Removes a page
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\page $pageToRemove
     */
    public function removeExcludepages(\DERHANSEN\SfBanners\Domain\Model\page $pageToRemove)
    {
        $this->excludepages->detach($pageToRemove);
    }

    /**
     * Setter for excludepages
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $excludepages Excludepages
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
     * Sets the recursive flag
     *
     * @param bool $recursive
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
     */
    public function increaseImpressions()
    {
        $this->impressions += 1;
    }

    /**
     * Updates the Impressions by 1
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
