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
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class Banner extends AbstractEntity
{
    protected string $title = '';
    protected string $description = '';
    protected int $type = 0;
    protected string $html = '';
    protected int $impressionsMax = 0;
    protected int $clicksMax = 0;
    protected int $impressions = 0;
    protected int $clicks = 0;
    protected bool $recursive = false;

    /**
     * @var ObjectStorage<Category>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $category;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $assets;

    /**
     * @var ObjectStorage<Page>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $excludepages;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->category = new ObjectStorage();
        $this->excludepages = new ObjectStorage();
        $this->assets = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function addCategory(Category $category): void
    {
        $this->category->attach($category);
    }

    public function removeCategory(Category $categoryToRemove): void
    {
        $this->category->detach($categoryToRemove);
    }

    public function getCategory(): ObjectStorage
    {
        return $this->category;
    }

    public function setCategory(ObjectStorage $category): void
    {
        $this->category = $category;
    }

    public function getClicksMax(): int
    {
        return $this->clicksMax;
    }

    public function setClicksMax(int $clicksMax): void
    {
        $this->clicksMax = $clicksMax;
    }

    public function getClicks(): int
    {
        return $this->clicks;
    }

    public function setClicks(int $clicks): void
    {
        $this->clicks = $clicks;
    }

    public function addExcludepages(Page $page): void
    {
        $this->excludepages->attach($page);
    }

    public function removeExcludepages(Page $pageToRemove): void
    {
        $this->excludepages->detach($pageToRemove);
    }

    public function setExcludepages(ObjectStorage $excludepages): void
    {
        $this->excludepages = $excludepages;
    }

    public function getExcludepages(): ObjectStorage
    {
        return $this->excludepages;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function setHtml(string $html): void
    {
        $this->html = $html;
    }

    public function getImpressionsMax(): int
    {
        return $this->impressionsMax;
    }

    public function setImpressionsMax(int $impressionsMax): void
    {
        $this->impressionsMax = $impressionsMax;
    }

    public function getImpressions(): int
    {
        return $this->impressions;
    }

    public function setImpressions(int $impressions): void
    {
        $this->impressions = $impressions;
    }

    public function getLink(): string
    {
        $this->assets->rewind();

        /** @var FileReference $fileReference */
        $fileReference = $this->assets->current();

        if ($fileReference === null) {
            return '';
        }

        /** @var \TYPO3\CMS\Core\Resource\FileReference $originalFileReference */
        $originalFileReference = $fileReference->getOriginalResource();
        return $originalFileReference->getLink();
    }

    public function setRecursive(bool $recursive): void
    {
        $this->recursive = $recursive;
    }

    public function getRecursive(): bool
    {
        return $this->recursive;
    }

    /**
     * Updates the Impressions by 1
     */
    public function increaseImpressions(): void
    {
        $this->impressions += 1;
    }

    /**
     * Updates the Impressions by 1
     */
    public function increaseClicks(): void
    {
        $this->clicks += 1;
    }

    public function getLinkUrl(): string
    {
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        return $cObj->getTypoLink_URL($this->getLink());
    }

    public function getLinkTarget(): string
    {
        $link = $this->getLink();
        $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $cObj->getTypoLink_URL($link);
        return $cObj->lastTypoLinkTarget;
    }

    public function getAssets(): ObjectStorage
    {
        return $this->assets;
    }

    public function setAssets(ObjectStorage $assets): void
    {
        $this->assets = $assets;
    }

    public function addAsset(FileReference $asset): void
    {
        $this->assets->attach($asset);
    }

    public function removeAsset(FileReference $asset): void
    {
        $this->assets->detach($asset);
    }
}
