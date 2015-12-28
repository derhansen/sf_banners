<?php
namespace DERHANSEN\SfBanners\ViewHelpers\Flash;

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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Flash params viewhelper
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class ParamsViewHelper extends AbstractViewHelper
{

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
        $settings = $this->templateVariableContainer->get('settings');
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
