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

/**
 * Test case for class \DERHANSEN\SfBanners\Domain\Model\Banner.
 */
class BannerTest extends UnitTestCase
{
    /**
     * @var Banner
     */
    protected $fixture;

    /**
     * Set up
     */
    public function setUp(): void
    {
        $this->fixture = new Banner();
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        unset($this->fixture);
    }

    /**
     * Test if title can be set
     *
     * @test
     */
    public function titleCanBeSetTest()
    {
        $title = 'a title';
        $this->fixture->setTitle($title);
        self::assertEquals($title, $this->fixture->getTitle());
    }

    /**
     * Test if description can be set
     *
     * @test
     */
    public function descriptionCanBeSetTest()
    {
        $description = 'a description';
        $this->fixture->setDescription($description);
        self::assertEquals($description, $this->fixture->getDescription());
    }

    /**
     * Test if type can be set
     *
     * @test
     */
    public function typeCanBeSetTest()
    {
        $type = 0;
        $this->fixture->setType($type);
        self::assertEquals($type, $this->fixture->getType());
    }

    /**
     * @test
     */
    public function getLinkRespectsFalMediaSetting()
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
     * Test if html can be set
     *
     * @test
     */
    public function htmlCanBeSetTest()
    {
        $html = '<p>test</p>';
        $this->fixture->setHtml($html);
        self::assertEquals($html, $this->fixture->getHtml());
    }

    /**
     * Test if impressionsmax can be set
     *
     * @test
     */
    public function impressionsMaxCanBeSetTest()
    {
        $impressionsMax = 100;
        $this->fixture->setImpressionsMax($impressionsMax);
        self::assertEquals($impressionsMax, $this->fixture->getImpressionsMax());
    }

    /**
     * Test if clicksmax can be set
     *
     * @test
     */
    public function clicksMaxCanBeSetTest()
    {
        $clicksMax = 100;
        $this->fixture->setClicksMax($clicksMax);
        self::assertEquals($clicksMax, $this->fixture->getClicksMax());
    }

    /**
     * Test if impressions can be set
     *
     * @test
     */
    public function impressionsCanBeSetTest()
    {
        $impressions = 100;
        $this->fixture->setImpressions($impressions);
        self::assertEquals($impressions, $this->fixture->getImpressions());
    }

    /**
     * Test if clicks can be set
     *
     * @test
     */
    public function clicksCanBeSetTest()
    {
        $clicks = 100;
        $this->fixture->setClicks($clicks);
        self::assertEquals($clicks, $this->fixture->getClicks());
    }

    /**
     * Test if recursive flag can be set
     *
     * @test
     */
    public function recursiveCanBeSet()
    {
        $this->fixture->setRecursive(true);
        self::assertTrue($this->fixture->getRecursive());
    }

    /**
     * @test
     */
    public function getCategoryReturnsInitialValueForCategory()
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
    public function setCategoryForObjectStorageContainingCategorySetsCategory()
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
    public function addCategoryToObjectStorageHoldingCategory()
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
    public function removeCategoryFromObjectStorageHoldingCategory()
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
    public function getExcludePagesReturnsInitialValueForExcudePages()
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
    public function setExcludePagesForObjectStorageContainingExcludePagesSetsExcludePages()
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
    public function addExludePagesToObjectStorageHoldingExcludePages()
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
    public function removeExludePagesFromObjectStorageHoldingExcludePages()
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
    public function getAssetsReturnsInitialValueForAsset()
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
    public function setAssetForObjectStorageContainingAssetSetsAsset()
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
    public function addAssetToObjectStorageHoldingAsses()
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
    public function removeAssetFromObjectStorageHoldingAsset()
    {
        $file = new FileReference();
        $assetsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->getMock();
        $assetsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($file));
        $this->fixture->setAssets($assetsObjectStorageMock);
        $this->fixture->removeAsset($file);
    }
}
