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
 * Test cases for the flash params viewhelper
 */
class Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelperTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * Test if viewhelper returns empty string, if wmode not set
	 *
	 * @test
	 * @return void
	 */
	public function viewHelperReturnsEmptyStringIfBannerAndWmodeNotSet() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings'] = '';

		$templateVariableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new Tx_Fluid_Core_Rendering_RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

		$actualResult = $viewHelper->render(NULL, NULL);
		$this->assertEquals('', $actualResult);
	}

	/**
	 * Test if default wmode is returned if not set in banner
	 *
	 * @test
	 * @return void
	 */
	public function viewHelperReturnsDefaultValueForWmodeIfNotSetInBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['wmode'] = 'opaque';

		$templateVariableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new Tx_Fluid_Core_Rendering_RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

		$banner = new Tx_SfBanners_Domain_Model_Banner();

		$actualResult = $viewHelper->render($banner, 'wmode');
		$this->assertEquals('opaque', $actualResult);
	}

	/**
	 * Test if default allowscriptaccess is returned if not set in banner
	 *
	 * @test
	 * @return void
	 */
	public function viewHelperReturnsDefaultValueForAllowScriptAccessIfNotSetInBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';

		$templateVariableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new Tx_Fluid_Core_Rendering_RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

		$banner = new Tx_SfBanners_Domain_Model_Banner();

		$actualResult = $viewHelper->render($banner, 'allowScriptAccess');
		$this->assertEquals('sameDomain', $actualResult);
	}

	/**
	 * Test if wmode is returned if set in banner
	 *
	 * @test
	 * @return void
	 */
	public function viewHelperReturnsValueForWmodeFromBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['wmode'] = 'opaque';

		$templateVariableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new Tx_Fluid_Core_Rendering_RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

		$banner = new Tx_SfBanners_Domain_Model_Banner();
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
	public function viewHelperReturnsValueForAllowScriptAccessFromBanner() {
		$viewHelper = new Tx_SfBanners_ViewHelpers_Flash_ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';

		$templateVariableContainer = new Tx_Fluid_Core_ViewHelper_TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new Tx_Fluid_Core_Rendering_RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

		$banner = new Tx_SfBanners_Domain_Model_Banner();
		$banner->setFlashAllowScriptAccess('someValue');

		$actualResult = $viewHelper->render($banner, 'allowScriptAccess');
		$this->assertEquals('someValue1', $actualResult);
	}
}
?>