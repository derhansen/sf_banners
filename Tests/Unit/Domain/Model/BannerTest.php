<?php
namespace DERHANSEN\SfBanners\Test\Unit\Domain\Model;

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use DERHANSEN\SfBanners\Domain\Model\Banner;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case for class \DERHANSEN\SfBanners\Domain\Model\Banner.
 */
class BannerTest extends UnitTestCase
{
    /**
     * @var \DERHANSEN\SfBanners\Domain\Model\Banner
     */
    protected $fixture;

    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        $this->fixture = new Banner();
    }

    /**
     * Tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * Test if title can be set
     *
     * @test
     * @return void
     */
    public function titleCanBeSetTest()
    {
        $title = 'a title';
        $this->fixture->setTitle($title);
        $this->assertEquals($title, $this->fixture->getTitle());
    }

    /**
     * Test if description can be set
     *
     * @test
     * @return void
     */
    public function descriptionCanBeSetTest()
    {
        $description = 'a description';
        $this->fixture->setDescription($description);
        $this->assertEquals($description, $this->fixture->getDescription());
    }

    /**
     * Test if type can be set
     *
     * @test
     * @return void
     */
    public function typeCanBeSetTest()
    {
        $type = 0;
        $this->fixture->setType($type);
        $this->assertEquals($type, $this->fixture->getType());
    }

    /**
     * Test if margin can be set
     *
     * @test
     * @return void
     */
    public function marginTopCanBeSetTest()
    {
        $margin = 100;
        $this->fixture->setMarginTop($margin);
        $this->assertEquals($margin, $this->fixture->getMarginTop());
    }

    /**
     * Test if margin can be set
     *
     * @test
     * @return void
     */
    public function marginRightCanBeSetTest()
    {
        $margin = 100;
        $this->fixture->setMarginRight($margin);
        $this->assertEquals($margin, $this->fixture->getMarginRight());
    }

    /**
     * Test if margin can be set
     *
     * @test
     * @return void
     */
    public function marginBottomCanBeSetTest()
    {
        $margin = 100;
        $this->fixture->setMarginBottom($margin);
        $this->assertEquals($margin, $this->fixture->getMarginBottom());
    }

    /**
     * Test if margin can be set
     *
     * @test
     * @return void
     */
    public function marginLeftCanBeSetTest()
    {
        $margin = 100;
        $this->fixture->setMarginLeft($margin);
        $this->assertEquals($margin, $this->fixture->getMarginLeft());
    }

    /**
     * @test
     */
    public function getLinkRespectsFalMediaSetting()
    {
        $mockFile = $this->getMockBuilder(File::class)
            ->setMethods(['getForLocalProcessing', 'getLink'])
            ->disableOriginalConstructor()
            ->getMock();
        $mockFile->expects($this->any())->method('getForLocalProcessing')->will($this->returnValue('/path/to/somefile.png'));
        $mockFile->expects($this->any())->method('getLink')->will($this->returnValue('https://www.typo3.org'));

        $mockFileRef = $this->getMockBuilder(FileReference::class)
            ->setMethods(['getOriginalResource'])
            ->disableOriginalConstructor()
            ->getMock();
        $mockFileRef->expects($this->any())->method('getOriginalResource')->will($this->returnValue($mockFile));

        $this->fixture->setType(0);
        $this->fixture->addAsset($mockFileRef);
        $this->assertEquals('https://www.typo3.org', $this->fixture->getLink());
    }

    /**
     * Test if html can be set
     *
     * @test
     * @return void
     */
    public function htmlCanBeSetTest()
    {
        $html = '<p>test</p>';
        $this->fixture->setHtml($html);
        $this->assertEquals($html, $this->fixture->getHtml());
    }

    /**
     * Test if impressionsmax can be set
     *
     * @test
     * @return void
     */
    public function impressionsMaxCanBeSetTest()
    {
        $impressionsMax = 100;
        $this->fixture->setImpressionsMax($impressionsMax);
        $this->assertEquals($impressionsMax, $this->fixture->getImpressionsMax());
    }

    /**
     * Test if clicksmax can be set
     *
     * @test
     * @return void
     */
    public function clicksMaxCanBeSetTest()
    {
        $clicksMax = 100;
        $this->fixture->setClicksMax($clicksMax);
        $this->assertEquals($clicksMax, $this->fixture->getClicksMax());
    }

    /**
     * Test if impressions can be set
     *
     * @test
     * @return void
     */
    public function impressionsCanBeSetTest()
    {
        $impressions = 100;
        $this->fixture->setImpressions($impressions);
        $this->assertEquals($impressions, $this->fixture->getImpressions());
    }

    /**
     * Test if clicks can be set
     *
     * @test
     * @return void
     */
    public function clicksCanBeSetTest()
    {
        $clicks = 100;
        $this->fixture->setClicks($clicks);
        $this->assertEquals($clicks, $this->fixture->getClicks());
    }

    /**
     * Test if recursive flag can be set
     *
     * @test
     * @return void
     */
    public function recursiveCanBeSet()
    {
        $this->fixture->setRecursive(true);
        $this->assertTrue($this->fixture->getRecursive());
    }

    /**
     * @test
     */
    public function getCategoryReturnsInitialValueForCategory()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->fixture->getCategory()
        );
    }

    /**
     * @test
     */
    public function setCategoryForObjectStorageContainingCategorySetsCategory()
    {
        $category = new \TYPO3\CMS\Extbase\Domain\Model\Category();
        $objectStorageHoldingExactlyOneCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneCategory->attach($category);
        $this->fixture->setCategory($objectStorageHoldingExactlyOneCategory);
        $this->assertEquals($objectStorageHoldingExactlyOneCategory, $this->fixture->getCategory());
    }

    /**
     * @test
     */
    public function addCategoryToObjectStorageHoldingCategory()
    {
        $category = new \TYPO3\CMS\Extbase\Domain\Model\Category();
        $categoryObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->setMethods(['attach'])->getMock();
        $categoryObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($category));
        $this->inject($this->fixture, 'category', $categoryObjectStorageMock);
        $this->fixture->addCategory($category);
    }

    /**
     * @test
     */
    public function removeCategoryFromObjectStorageHoldingCategory()
    {
        $category = new \TYPO3\CMS\Extbase\Domain\Model\Category();
        $categoryObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->setMethods(['detach'])->getMock();
        $categoryObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($category));
        $this->inject($this->fixture, 'category', $categoryObjectStorageMock);
        $this->fixture->removeCategory($category);
    }

    /**
     * @test
     */
    public function getExcludePagesReturnsInitialValueForExcudePages()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->fixture->getExcludepages()
        );
    }

    /**
     * @test
     */
    public function setExcludePagesForObjectStorageContainingExcludePagesSetsExcludePages()
    {
        $page = new \DERHANSEN\SfBanners\Domain\Model\Page();
        $objectStorageHoldingExactlyOnePage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOnePage->attach($page);
        $this->fixture->setExcludepages($objectStorageHoldingExactlyOnePage);
        $this->assertEquals($objectStorageHoldingExactlyOnePage, $this->fixture->getExcludepages());
    }

    /**
     * @test
     */
    public function addExludePagesToObjectStorageHoldingExcludePages()
    {
        $page = new \DERHANSEN\SfBanners\Domain\Model\Page();
        $pageObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->setMethods(['attach'])->getMock();
        $pageObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($page));
        $this->inject($this->fixture, 'excludepages', $pageObjectStorageMock);
        $this->fixture->addExcludepages($page);
    }

    /**
     * @test
     */
    public function removeExludePagesFromObjectStorageHoldingExcludePages()
    {
        $page = new \DERHANSEN\SfBanners\Domain\Model\Page();
        $pageObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->setMethods(['detach'])->getMock();
        $pageObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($page));
        $this->inject($this->fixture, 'excludepages', $pageObjectStorageMock);
        $this->fixture->removeExcludepages($page);
    }

    /**
     * @test
     */
    public function getAssetsReturnsInitialValueForAsset()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->assertEquals(
            $newObjectStorage,
            $this->fixture->getAssets()
        );
    }

    /**
     * @test
     */
    public function setAssetForObjectStorageContainingAssetSetsAsset()
    {
        $file = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneFile = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFile->attach($file);
        $this->fixture->setAssets($objectStorageHoldingExactlyOneFile);
        $this->assertEquals($objectStorageHoldingExactlyOneFile, $this->fixture->getAssets());
    }

    /**
     * @test
     */
    public function addAssetToObjectStorageHoldingAsses()
    {
        $file = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $assetsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->setMethods(['attach'])->getMock();
        $assetsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($file));
        $this->inject($this->fixture, 'assets', $assetsObjectStorageMock);
        $this->fixture->addAsset($file);
    }

    /**
     * @test
     */
    public function removeAssetFromObjectStorageHoldingAsset()
    {
        $file = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $assetsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)->setMethods(['detach'])->getMock();
        $assetsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($file));
        $this->inject($this->fixture, 'assets', $assetsObjectStorageMock);
        $this->fixture->removeAsset($file);
    }
}
