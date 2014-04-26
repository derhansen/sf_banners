<?php
namespace DERHANSEN\SfBanners\ViewHelpers\Flash;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Torben Hansen <derhansen@gmail.com>, Skyfillers GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Flash params viewhelper
 *
 * @package sf_banners
 */
class ParamsViewHelper extends AbstractViewHelper {

	/**
	 * Returns the requested flash variable depending on the setting in the banner.
	 * If no value is set in the banner object, the default value from TS setting
	 * is returned
	 *
	 * @param \DERHANSEN\SfBanners\Domain\Model\Banner $banner The banner
	 * @param string $flashSetting Flash settings
	 * @return string
	 */
	public function render($banner = NULL, $flashSetting = '') {
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
