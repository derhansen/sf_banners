<?php

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

/**
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Banner Management
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelperTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @test
	 */
	public function viewHelperReturnsEmptyStringIfBannerAndWmodeNotSet() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings'] = '';
		$variableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		$viewHelper->setTemplateVariableContainer($variableContainer);

		$actualResult = $viewHelper->render(NULL, NULL);
		$this->assertEquals('', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperReturnsDefaultValueForWmodeIfNotSetInBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['wmode'] = 'opaque';
		$variableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		$viewHelper->setTemplateVariableContainer($variableContainer);

		$banner = new Tx_SfBanners_Domain_Model_Banner();

		$actualResult = $viewHelper->render($banner, 'wmode');
		$this->assertEquals('opaque', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperReturnsDefaultValueForAllowScriptAccessIfNotSetInBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';
		$variableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		$viewHelper->setTemplateVariableContainer($variableContainer);

		$banner = new Tx_SfBanners_Domain_Model_Banner();

		$actualResult = $viewHelper->render($banner, 'allowScriptAccess');
		$this->assertEquals('sameDomain', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperReturnsValueForWmodeFromBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['wmode'] = 'opaque';
		$variableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		$viewHelper->setTemplateVariableContainer($variableContainer);

		$banner = new Tx_SfBanners_Domain_Model_Banner();
		$banner->setFlashWmode('someValue');

		$actualResult = $viewHelper->render($banner, 'wmode');
		$this->assertEquals('someValue', $actualResult);
	}

	/**
	 * @test
	 */
	public function viewHelperReturnsValueForAllowScriptAccessFromBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';
		$variableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		$viewHelper->setTemplateVariableContainer($variableContainer);

		$banner = new Tx_SfBanners_Domain_Model_Banner();
		$banner->setFlashAllowScriptAccess('someValue');

		$actualResult = $viewHelper->render($banner, 'allowScriptAccess');
		$this->assertEquals('someValue', $actualResult);
	}
}
?>