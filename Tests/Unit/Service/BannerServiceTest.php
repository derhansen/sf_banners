<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Test\Unit\Service;

use DERHANSEN\SfBanners\Domain\Model\Banner;
use DERHANSEN\SfBanners\Domain\Model\BannerDemand;
use DERHANSEN\SfBanners\Service\BannerService;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test cases for the banner service
 */
class BannerServiceTest extends UnitTestCase
{
    /**
     * @var BannerService
     */
    protected $bannerService;

    /**
     * @var BannerDemand
     */
    protected $demand;

    /**
     * @var QueryResult
     */
    protected $queryResult;

    /**
     * Set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->bannerService = new BannerService();
        $this->demand = new BannerDemand();
        $this->demand->setDisplayMode('all');

        $mockPersistenceManager = $this->createMock(PersistenceManagerInterface::class);
        $mockPersistenceManager->expects(self::any())->method('getObjectDataByQuery')->willReturn(['one', 'two']);
        $mockPersistenceManager->expects(self::any())->method('getObjectCountByQuery')->willReturn(2);
        $mockQuery = $this->createMock(QueryInterface::class);
        $this->queryResult = $this->getAccessibleMock(QueryResult::class, ['dummy'], [], '', false);
        $this->queryResult->_set('persistenceManager', $mockPersistenceManager);
        $this->queryResult->_set('query', $mockQuery);
    }

    /**
     * Tear down
     */
    public function tearDown(): void
    {
        unset($this->bannerService, $this->demand);
    }

    /**
     * Test if additional css returns an empty string if banner has no margin
     *
     * @test
     */
    public function getAdditionalCssReturnsEmptyStringIfBannerHasNoMarginsTest()
    {
        $mockQueryResult = $this->createMock(QueryResultInterface::class);
        $result = $this->bannerService->getAdditionalCss($mockQueryResult);
        self::assertEquals('', $result);
    }

    /**
     * Test if additional css returns correct top margin
     *
     * @test
     */
    public function getAdditionalCssReturnsMarginTopIfBannerHasMarginTopTest()
    {
        $bannerUid = 100;
        $banner = $this->getMockBuilder(Banner::class)->getMock();
        $banner->expects(self::any())->method('getMarginTop')->willReturn(10);
        $banner->expects(self::any())->method('getMarginRight')->willReturn(0);
        $banner->expects(self::any())->method('getMarginBottom')->willReturn(0);
        $banner->expects(self::any())->method('getMarginLeft')->willReturn(0);
        $banner->expects(self::once())->method('getUid')->willReturn($bannerUid);

        $mockDataMapper = $this->createMock(DataMapper::class);
        $mockDataMapper->expects(self::any())->method('map')->willReturn([$banner]);
        $this->queryResult->_set('dataMapper', $mockDataMapper);

        $expected = '.banner-' . $bannerUid . ' { margin: 10px 0px 0px 0px; }' . chr(10) . chr(13);
        $result = $this->bannerService->getAdditionalCss($this->queryResult);
        self::assertEquals($expected, $result);
    }

    /**
     * Test if additional css returns correct right margin
     *
     * @test
     */
    public function getAdditionalCssReturnsMarginRightIfBannerHasMarginRightTest()
    {
        $bannerUid = 100;
        $banner = $this->getMockBuilder(Banner::class)->getMock();
        $banner->expects(self::any())->method('getMarginTop')->willReturn(0);
        $banner->expects(self::any())->method('getMarginRight')->willReturn(10);
        $banner->expects(self::any())->method('getMarginBottom')->willReturn(0);
        $banner->expects(self::any())->method('getMarginLeft')->willReturn(0);
        $banner->expects(self::once())->method('getUid')->willReturn($bannerUid);

        $mockDataMapper = $this->createMock(DataMapper::class);
        $mockDataMapper->expects(self::any())->method('map')->willReturn([$banner]);
        $this->queryResult->_set('dataMapper', $mockDataMapper);

        $expected = '.banner-' . $bannerUid . ' { margin: 0px 10px 0px 0px; }' . chr(10) . chr(13);
        $result = $this->bannerService->getAdditionalCss($this->queryResult);
        self::assertEquals($expected, $result);
    }

    /**
     * Test if additional css returns correct bottom margin
     *
     * @test
     */
    public function getAdditionalCssReturnsMarginBottomIfBannerHasMarginBottomTest()
    {
        $bannerUid = 100;
        $banner = $this->getMockBuilder(Banner::class)->getMock();
        $banner->expects(self::any())->method('getMarginTop')->willReturn(0);
        $banner->expects(self::any())->method('getMarginRight')->willReturn(0);
        $banner->expects(self::any())->method('getMarginBottom')->willReturn(10);
        $banner->expects(self::any())->method('getMarginLeft')->willReturn(0);
        $banner->expects(self::once())->method('getUid')->willReturn($bannerUid);

        $mockDataMapper = $this->createMock(DataMapper::class);
        $mockDataMapper->expects(self::any())->method('map')->willReturn([$banner]);
        $this->queryResult->_set('dataMapper', $mockDataMapper);

        $expected = '.banner-' . $bannerUid . ' { margin: 0px 0px 10px 0px; }' . chr(10) . chr(13);
        $result = $this->bannerService->getAdditionalCss($this->queryResult);
        self::assertEquals($expected, $result);
    }

    /**
     * Test if additional css returns correct left margin
     *
     * @test
     */
    public function getAdditionalCssReturnsMarginLeftIfBannerHasMarginLeftTest()
    {
        $bannerUid = 100;
        $banner = $this->getMockBuilder(Banner::class)->getMock();
        $banner->expects(self::any())->method('getMarginTop')->willReturn(0);
        $banner->expects(self::any())->method('getMarginRight')->willReturn(0);
        $banner->expects(self::any())->method('getMarginBottom')->willReturn(0);
        $banner->expects(self::any())->method('getMarginLeft')->willReturn(10);
        $banner->expects(self::once())->method('getUid')->willReturn($bannerUid);

        $mockDataMapper = $this->createMock(DataMapper::class);
        $mockDataMapper->expects(self::any())->method('map')->willReturn([$banner]);
        $this->queryResult->_set('dataMapper', $mockDataMapper);

        $expected = '.banner-' . $bannerUid . ' { margin: 0px 0px 0px 10px; }' . chr(10) . chr(13);
        $result = $this->bannerService->getAdditionalCss($this->queryResult);
        self::assertEquals($expected, $result);
    }

    /**
     * Test if additional css returns correct margins for multiple banners
     *
     * @test
     */
    public function getAdditionalCssReturnsCssForMultipleBannersTest()
    {
        $bannerUid1 = 100;
        $bannerUid2 = 200;
        $banner1 = $this->getMockBuilder(Banner::class)->getMock();
        $banner1->expects(self::any())->method('getMarginTop')->willReturn(0);
        $banner1->expects(self::any())->method('getMarginRight')->willReturn(10);
        $banner1->expects(self::any())->method('getMarginBottom')->willReturn(0);
        $banner1->expects(self::any())->method('getMarginLeft')->willReturn(10);
        $banner1->expects(self::once())->method('getUid')->willReturn($bannerUid1);
        $banner2 = $this->getMockBuilder(Banner::class)->getMock();
        $banner2->expects(self::any())->method('getMarginTop')->willReturn(10);
        $banner2->expects(self::any())->method('getMarginRight')->willReturn(0);
        $banner2->expects(self::any())->method('getMarginBottom')->willReturn(10);
        $banner2->expects(self::any())->method('getMarginLeft')->willReturn(0);
        $banner2->expects(self::once())->method('getUid')->willReturn($bannerUid2);

        $mockDataMapper = $this->createMock(DataMapper::class);
        $mockDataMapper->expects(self::any())->method('map')->willReturn([$banner1, $banner2]);
        $this->queryResult->_set('dataMapper', $mockDataMapper);

        $expected = '.banner-' . $bannerUid1 . ' { margin: 0px 10px 0px 10px; }' . chr(10) . chr(13);
        $expected .= '.banner-' . $bannerUid2 . ' { margin: 10px 0px 10px 0px; }' . chr(10) . chr(13);
        $result = $this->bannerService->getAdditionalCss($this->queryResult);
        self::assertEquals($expected, $result);
    }

    /**
     * Test if no CSS file is returned if no banners given
     *
     * @test
     */
    public function getAdditionalCssFileReturnsEmptyStringIfNoBannersFoundTest()
    {
        $mockDataMapper = $this->createMock(DataMapper::class);
        $mockDataMapper->expects(self::any())->method('map')->willReturn([]);
        $this->queryResult->_set('dataMapper', $mockDataMapper);

        $result = $this->bannerService->getAdditionalCssFile($this->queryResult);
        self::assertEmpty($result);
    }

    /**
     * Test if returned file contains .css as extension
     *
     * @test
     */
    public function getAdditionalCssFileReturnsFilenameTest()
    {
        $bannerUid = 100;
        $banner = $this->getMockBuilder(Banner::class)->getMock();
        $banner->expects(self::any())->method('getMarginTop')->willReturn(0);
        $banner->expects(self::any())->method('getMarginRight')->willReturn(0);
        $banner->expects(self::any())->method('getMarginBottom')->willReturn(0);
        $banner->expects(self::any())->method('getMarginLeft')->willReturn(10);
        $banner->expects(self::once())->method('getUid')->willReturn($bannerUid);

        $mockDataMapper = $this->createMock(DataMapper::class);
        $mockDataMapper->expects(self::any())->method('map')->willReturn([$banner]);
        $this->queryResult->_set('dataMapper', $mockDataMapper);

        $expected = '/\.css/';
        $result = $this->bannerService->getAdditionalCssFile($this->queryResult);
        self::assertMatchesRegularExpression($expected, $result);
    }
}
