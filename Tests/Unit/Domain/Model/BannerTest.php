<?php
namespace DERHANSEN\SfBanners\Test\Unit\Domain\Model;

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

use DERHANSEN\SfBanners\Domain\Model\Banner;
use Nimut\TestingFramework\TestCase\UnitTestCase;
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
     * Test if image can be set
     *
     * @test
     * @return void
     */
    public function imageCanBeSetTest()
    {
        $image = 'image.jpg';
        $this->fixture->setImage($image);
        $this->assertEquals($image, $this->fixture->getImage());
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
     * Test if alttext can be set
     *
     * @test
     * @return void
     */
    public function altTextCanBeSetTest()
    {
        $altText = 'some text';
        $this->fixture->setAlttext($altText);
        $this->assertEquals($altText, $this->fixture->getAlttext());
    }

    /**
     * Test if link can be set
     *
     * @test
     * @return void
     */
    public function linkCanBeSetTest()
    {
        $link = 'www.domain.tld';
        $this->fixture->setLink($link);
        $this->assertEquals($link, $this->fixture->getLink());
    }

    /**
     * @test
     */
    public function getLinkRespectsFalMediaSetting()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sf_banners'] = serialize([
            'falMedia' => 1
        ]);

        $mockFile = $this->getMock('TYPO3\\CMS\\Core\\Resource\\File', ['getForLocalProcessing', 'getLink'], [], '', false);
        $mockFile->expects($this->any())->method('getForLocalProcessing')->will($this->returnValue('/path/to/somefile.png'));
        $mockFile->expects($this->any())->method('getLink')->will($this->returnValue('https://www.typo3.org'));
        $mockFileRef = $this->getMock('TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference',
            ['getOriginalResource'], [], '', false);
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
     * Test if flash can be set
     *
     * @test
     * @return void
     */
    public function flashCanBeSetTest()
    {
        $flash = 'flash.swf';
        $this->fixture->setFlash($flash);
        $this->assertEquals($flash, $this->fixture->getFlash());
    }

    /**
     * Test if flashwidth can be set
     *
     * @test
     * @return void
     */
    public function flashWidthCanBeSetTest()
    {
        $width = 100;
        $this->fixture->setFlashWidth($width);
        $this->assertEquals($width, $this->fixture->getFlashWidth());
    }

    /**
     * Test if flshheight can be set
     *
     * @test
     * @return void
     */
    public function flashHeighCanBeSetTest()
    {
        $height = 100;
        $this->fixture->setFlashHeight($height);
        $this->assertEquals($height, $this->fixture->getFlashHeight());
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
     * Test if allowscriptaccess can be set
     *
     * @test
     * @return void
     */
    public function flashAllowScriptAccessCanBeSetTest()
    {
        $flashAllowScriptAccess = 'sameDomain';
        $this->fixture->setflashAllowScriptAccess($flashAllowScriptAccess);
        $this->assertEquals($flashAllowScriptAccess, $this->fixture->getflashAllowScriptAccess());
    }

    /**
     * Test if wmode can be set
     *
     * @test
     * @return void
     */
    public function flashWmodeCanBeSetTest()
    {
        $flashWmode = 'opaque';
        $this->fixture->setFlashWmode($flashWmode);
        $this->assertEquals($flashWmode, $this->fixture->getFlashWmode());
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
        $category = new \DERHANSEN\SfBanners\Domain\Model\Category();
        $objectStorageHoldingExactlyOneCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneCategory->attach($category);
        $this->fixture->setCategory($objectStorageHoldingExactlyOneCategory);
        $this->assertAttributeEquals(
            $objectStorageHoldingExactlyOneCategory,
            'category',
            $this->fixture
        );
    }

    /**
     * @test
     */
    public function addCategoryToObjectStorageHoldingCategory()
    {
        $category = new \DERHANSEN\SfBanners\Domain\Model\Category();
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
        $category = new \DERHANSEN\SfBanners\Domain\Model\Category();
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
        $this->assertAttributeEquals(
            $objectStorageHoldingExactlyOnePage,
            'excludepages',
            $this->fixture
        );
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
        $this->assertAttributeEquals(
            $objectStorageHoldingExactlyOneFile,
            'assets',
            $this->fixture
        );
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
