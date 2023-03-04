<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Test\Unit\Domain\Model;

use DERHANSEN\SfBanners\Domain\Model\Banner;
use DERHANSEN\SfBanners\Domain\Model\Page;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BannerTest extends UnitTestCase
{
    protected Banner $fixture;

    public function setUp(): void
    {
        $this->fixture = new Banner();
    }

    public function tearDown(): void
    {
        unset($this->fixture);
    }

    /**
     * @test
     */
    public function titleCanBeSetTest(): void
    {
        $title = 'a title';
        $this->fixture->setTitle($title);
        self::assertEquals($title, $this->fixture->getTitle());
    }

    /**
     * @test
     */
    public function descriptionCanBeSetTest(): void
    {
        $description = 'a description';
        $this->fixture->setDescription($description);
        self::assertEquals($description, $this->fixture->getDescription());
    }

    /**
     * @test
     */
    public function typeCanBeSetTest(): void
    {
        $type = 0;
        $this->fixture->setType($type);
        self::assertEquals($type, $this->fixture->getType());
    }

    /**
     * @test
     */
    public function getLinkRespectsFalMediaSetting(): void
    {
        $mockFile = $this->getMockBuilder(\TYPO3\CMS\Core\Resource\FileReference::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockFile->expects(self::any())->method('getForLocalProcessing')->willReturn('/path/to/somefile.png');
        $mockFile->expects(self::any())->method('getLink')->willReturn('https://www.typo3.org');

        $mockFileRef = $this->getMockBuilder(FileReference::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockFileRef->expects(self::any())->method('getOriginalResource')->willReturn($mockFile);

        $this->fixture->setType(0);
        $this->fixture->addAsset($mockFileRef);
        self::assertEquals('https://www.typo3.org', $this->fixture->getLink());
    }

    /**
     * @test
     */
    public function htmlCanBeSetTest(): void
    {
        $html = '<p>test</p>';
        $this->fixture->setHtml($html);
        self::assertEquals($html, $this->fixture->getHtml());
    }

    /**
     * @test
     */
    public function impressionsMaxCanBeSetTest(): void
    {
        $impressionsMax = 100;
        $this->fixture->setImpressionsMax($impressionsMax);
        self::assertEquals($impressionsMax, $this->fixture->getImpressionsMax());
    }

    /**
     * @test
     */
    public function clicksMaxCanBeSetTest(): void
    {
        $clicksMax = 100;
        $this->fixture->setClicksMax($clicksMax);
        self::assertEquals($clicksMax, $this->fixture->getClicksMax());
    }

    /**
     * @test
     */
    public function impressionsCanBeSetTest(): void
    {
        $impressions = 100;
        $this->fixture->setImpressions($impressions);
        self::assertEquals($impressions, $this->fixture->getImpressions());
    }

    /**
     * @test
     */
    public function clicksCanBeSetTest(): void
    {
        $clicks = 100;
        $this->fixture->setClicks($clicks);
        self::assertEquals($clicks, $this->fixture->getClicks());
    }

    /**
     * @test
     */
    public function recursiveCanBeSet(): void
    {
        $this->fixture->setRecursive(true);
        self::assertTrue($this->fixture->getRecursive());
    }

    /**
     * @test
     */
    public function getCategoryReturnsInitialValueForCategory(): void
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->fixture->getCategory()
        );
    }

    /**
     * @test
     */
    public function setCategoryForObjectStorageContainingCategorySetsCategory(): void
    {
        $category = new Category();
        $objectStorageHoldingExactlyOneCategory = new ObjectStorage();
        $objectStorageHoldingExactlyOneCategory->attach($category);
        $this->fixture->setCategory($objectStorageHoldingExactlyOneCategory);
        self::assertEquals($objectStorageHoldingExactlyOneCategory, $this->fixture->getCategory());
    }

    /**
     * @test
     */
    public function addCategoryToObjectStorageHoldingCategory(): void
    {
        $category = new Category();
        $categoryObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->getMock();
        $categoryObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($category));
        $this->fixture->setCategory($categoryObjectStorageMock);
        $this->fixture->addCategory($category);
    }

    /**
     * @test
     */
    public function removeCategoryFromObjectStorageHoldingCategory(): void
    {
        $category = new Category();
        $categoryObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->getMock();
        $categoryObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($category));
        $this->fixture->setCategory($categoryObjectStorageMock);
        $this->fixture->removeCategory($category);
    }

    /**
     * @test
     */
    public function getExcludePagesReturnsInitialValueForExcudePages(): void
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->fixture->getExcludepages()
        );
    }

    /**
     * @test
     */
    public function setExcludePagesForObjectStorageContainingExcludePagesSetsExcludePages(): void
    {
        $page = new Page();
        $objectStorageHoldingExactlyOnePage = new ObjectStorage();
        $objectStorageHoldingExactlyOnePage->attach($page);
        $this->fixture->setExcludepages($objectStorageHoldingExactlyOnePage);
        self::assertEquals($objectStorageHoldingExactlyOnePage, $this->fixture->getExcludepages());
    }

    /**
     * @test
     */
    public function addExludePagesToObjectStorageHoldingExcludePages(): void
    {
        $page = new Page();
        $pageObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->getMock();
        $pageObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($page));
        $this->fixture->setExcludepages($pageObjectStorageMock);
        $this->fixture->addExcludepages($page);
    }

    /**
     * @test
     */
    public function removeExludePagesFromObjectStorageHoldingExcludePages(): void
    {
        $page = new Page();
        $pageObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->getMock();
        $pageObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($page));
        $this->fixture->setExcludepages($pageObjectStorageMock);
        $this->fixture->removeExcludepages($page);
    }

    /**
     * @test
     */
    public function getAssetsReturnsInitialValueForAsset(): void
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->fixture->getAssets()
        );
    }

    /**
     * @test
     */
    public function setAssetForObjectStorageContainingAssetSetsAsset(): void
    {
        $file = new FileReference();
        $objectStorageHoldingExactlyOneFile = new ObjectStorage();
        $objectStorageHoldingExactlyOneFile->attach($file);
        $this->fixture->setAssets($objectStorageHoldingExactlyOneFile);
        self::assertEquals($objectStorageHoldingExactlyOneFile, $this->fixture->getAssets());
    }

    /**
     * @test
     */
    public function addAssetToObjectStorageHoldingAsses(): void
    {
        $file = new FileReference();
        $assetsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->getMock();
        $assetsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($file));
        $this->fixture->setAssets($assetsObjectStorageMock);
        $this->fixture->addAsset($file);
    }

    /**
     * @test
     */
    public function removeAssetFromObjectStorageHoldingAsset(): void
    {
        $file = new FileReference();
        $assetsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->getMock();
        $assetsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($file));
        $this->fixture->setAssets($assetsObjectStorageMock);
        $this->fixture->removeAsset($file);
    }
}
