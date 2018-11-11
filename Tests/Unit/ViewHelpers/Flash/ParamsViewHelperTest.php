<?php
namespace DERHANSEN\SfBanners\Test\Unit\ViewHelpers\Flash;

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use DERHANSEN\SfBanners\Domain\Model\Banner;
use DERHANSEN\SfBanners\ViewHelpers\Flash\ParamsViewHelper;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;

/**
 * Test cases for the flash params viewhelper
 */
class ParamsViewHelperTest extends UnitTestCase
{

    /**
     * Test if viewhelper returns empty string, if wmode not set
     *
     * @test
     * @return void
     */
    public function viewHelperReturnsEmptyStringIfBannerAndWmodeNotSet()
    {
        $viewHelper = new ParamsViewHelper();

        $settings = [];
        $settings['settings'] = '';

        $mockConfigurationManager = $this->getMockBuilder(ConfigurationManager::class)->getMock();
        $mockConfigurationManager->expects($this->once())->method('getConfiguration')->will(
            $this->returnValue($settings)
        );
        $this->inject($viewHelper, 'configurationManager', $mockConfigurationManager);

        $actualResult = $viewHelper->render(null, null);
        $this->assertEquals('', $actualResult);
    }

    /**
     * Test if default wmode is returned if not set in banner
     *
     * @test
     * @return void
     */
    public function viewHelperReturnsDefaultValueForWmodeIfNotSetInBanner()
    {
        $viewHelper = new ParamsViewHelper();

        $settings = [];
        $settings['defaultFlashVars']['wmode'] = 'opaque';

        $mockConfigurationManager = $this->getMockBuilder(ConfigurationManager::class)->getMock();
        $mockConfigurationManager->expects($this->once())->method('getConfiguration')->will(
            $this->returnValue($settings)
        );
        $this->inject($viewHelper, 'configurationManager', $mockConfigurationManager);

        $banner = new Banner();

        $actualResult = $viewHelper->render($banner, 'wmode');
        $this->assertEquals('opaque', $actualResult);
    }

    /**
     * Test if default allowscriptaccess is returned if not set in banner
     *
     * @test
     * @return void
     */
    public function viewHelperReturnsDefaultValueForAllowScriptAccessIfNotSetInBanner()
    {
        $viewHelper = new ParamsViewHelper();

        $settings = [];
        $settings['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';

        $mockConfigurationManager = $this->getMockBuilder(ConfigurationManager::class)->getMock();
        $mockConfigurationManager->expects($this->once())->method('getConfiguration')->will(
            $this->returnValue($settings)
        );
        $this->inject($viewHelper, 'configurationManager', $mockConfigurationManager);

        $banner = new Banner();

        $actualResult = $viewHelper->render($banner, 'allowScriptAccess');
        $this->assertEquals('sameDomain', $actualResult);
    }

    /**
     * Test if wmode is returned if set in banner
     *
     * @test
     * @return void
     */
    public function viewHelperReturnsValueForWmodeFromBanner()
    {
        $viewHelper = new ParamsViewHelper();

        $settings = [];
        $settings['defaultFlashVars']['wmode'] = 'opaque';

        $mockConfigurationManager = $this->getMockBuilder(ConfigurationManager::class)->getMock();
        $mockConfigurationManager->expects($this->once())->method('getConfiguration')->will(
            $this->returnValue($settings)
        );
        $this->inject($viewHelper, 'configurationManager', $mockConfigurationManager);

        $banner = new Banner();
        $banner->setFlashWmode('someValue');

        $actualResult = $viewHelper->render($banner, 'wmode');
        $this->assertEquals('someValue', $actualResult);
    }

    /**
     * Test if allowscriptaccess is returned if set in banner
     *
     * @test
     * @return void
     */
    public function viewHelperReturnsValueForAllowScriptAccessFromBanner()
    {
        $viewHelper = new ParamsViewHelper();

        $settings = [];
        $settings['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';

        $mockConfigurationManager = $this->getMockBuilder(ConfigurationManager::class)->getMock();
        $mockConfigurationManager->expects($this->once())->method('getConfiguration')->will(
            $this->returnValue($settings)
        );
        $this->inject($viewHelper, 'configurationManager', $mockConfigurationManager);

        $banner = new Banner();
        $banner->setFlashAllowScriptAccess('someValue');

        $actualResult = $viewHelper->render($banner, 'allowScriptAccess');
        $this->assertEquals('someValue', $actualResult);
    }
}
