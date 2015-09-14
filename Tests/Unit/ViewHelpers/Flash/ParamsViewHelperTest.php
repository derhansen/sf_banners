<?php
namespace DERHANSEN\SfBanners\Test\Unit\ViewHelpers\Flash;

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

use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Fluid\Core\ViewHelper\TemplateVariableContainer;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContext;
use DERHANSEN\SfBanners\ViewHelpers\Flash\ParamsViewHelper;
use DERHANSEN\SfBanners\Domain\Model\Banner;

/**
 * Test cases for the flash params viewhelper
 */
class ParamsViewHelperTest extends UnitTestCase {

	/**
	 * Test if viewhelper returns empty string, if wmode not set
	 *
	 * @test
	 * @return void
	 */
	public function viewHelperReturnsEmptyStringIfBannerAndWmodeNotSet() {
		$viewHelper = new ParamsViewHelper();

		$settings = array();
		$settings['settings'] = '';

		$templateVariableContainer = new TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new RenderingContext();
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
		$viewHelper = new ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['wmode'] = 'opaque';

		$templateVariableContainer = new TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

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
	public function viewHelperReturnsDefaultValueForAllowScriptAccessIfNotSetInBanner() {
		$viewHelper = new ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';

		$templateVariableContainer = new TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

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
	public function viewHelperReturnsValueForWmodeFromBanner() {
		$viewHelper = new ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['wmode'] = 'opaque';

		$templateVariableContainer = new TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

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
	public function viewHelperReturnsValueForAllowScriptAccessFromBanner() {
		$viewHelper = new ParamsViewHelper();

		$settings = array();
		$settings['settings']['defaultFlashVars']['allowScriptAccess'] = 'sameDomain';

		$templateVariableContainer = new TemplateVariableContainer($settings);
		if (method_exists($viewHelper, 'setTemplateVariableContainer')) {
			$viewHelper->setTemplateVariableContainer($templateVariableContainer);
		} else {
			$renderingContext = new RenderingContext();
			$renderingContext->injectTemplateVariableContainer($templateVariableContainer);
			$viewHelper->setRenderingContext($renderingContext);
		}

		$banner = new Banner();
		$banner->setFlashAllowScriptAccess('someValue');

		$actualResult = $viewHelper->render($banner, 'allowScriptAccess');
		$this->assertEquals('someValue', $actualResult);
	}
}