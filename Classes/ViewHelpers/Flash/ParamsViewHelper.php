<?php
namespace DERHANSEN\SfBanners\ViewHelpers\Flash;

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Flash params viewhelper
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class ParamsViewHelper extends AbstractViewHelper
{
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
    ) {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Returns TypoSript settings for the extension
     *
     * @return array
     */
    public function getSettings()
    {
        $typoScript = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'SfBanners',
            'Pi1'
        );
        return $typoScript;
    }

    /**
     * Returns the requested flash variable depending on the setting in the banner.
     * If no value is set in the banner object, the default value from TS setting
     * is returned
     *
     * @param \DERHANSEN\SfBanners\Domain\Model\Banner $banner The banner
     * @param string $flashSetting Flash settings
     * @return string
     */
    public function render($banner = null, $flashSetting = '')
    {
        $settings = $this->getSettings();
        $retVal = '';
        switch ($flashSetting) {
            case 'wmode':
                if ($banner->getFlashWmode() != '') {
                    $retVal = $banner->getFlashWmode();
                } else {
                    $retVal = $settings['defaultFlashVars']['wmode'];
                }
                break;
            case 'allowScriptAccess':
                if ($banner->getFlashAllowScriptAccess() != '') {
                    $retVal = $banner->getFlashAllowScriptAccess();
                } else {
                    $retVal = $settings['defaultFlashVars']['allowScriptAccess'];
                }
                break;
            default:

        }
        return $retVal;
    }
}
