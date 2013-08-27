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
 * Banner Controller
 *
 * @package sf_banners
 */
class Tx_SfBanners_Controller_BannerController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * Banner Service
	 *
	 * @var Tx_SfBanners_Service_BannerService
	 */
	protected $bannerService;

	/**
	 * bannerRepository
	 *
	 * @var Tx_SfBanners_Domain_Repository_BannerRepository
	 */
	protected $bannerRepository;

	/**
	 * Hash Service
	 *
	 * @var Tx_SfBanners_Service_HashServiceHelper
	 */
	protected $hashService;

	/**
	 * injectBannerRepository
	 *
	 * @param Tx_SfBanners_Domain_Repository_BannerRepository $bannerRepository
	 * @return void
	 */
	public function injectBannerRepository(Tx_SfBanners_Domain_Repository_BannerRepository $bannerRepository) {
		$this->bannerRepository = $bannerRepository;
	}

	/**
	 * injectBannerService
	 *
	 * @param Tx_SfBanners_Service_BannerService $bannerService
	 * @return void
	 */
	public function injectBannerService(Tx_SfBanners_Service_BannerService $bannerService) {
		$this->bannerService = $bannerService;
	}

	/**
	 * injectHashService
	 *
	 * @param Tx_SfBanners_Service_HashServiceHelper $hashService
	 * @return void
	 */
	public function injectHashService(Tx_SfBanners_Service_HashServiceHelper $hashService) {
		$this->hashService = $hashService;
	}

	/**
	 * Instance of Caching Framework
	 *
	 * @var t3lib_cache_frontend_AbstractFrontend
	 */
	protected $cacheInstance;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->initializeCache();
	}

	/**
	 * Initialize cache instance to be ready to use
	 *
	 * @return void
	 */
	protected function initializeCache() {
		t3lib_cache::initializeCachingFramework();
		try {
			$this->cacheInstance = $GLOBALS['typo3CacheManager']->getCache('sfbanners_cache');
		} catch (t3lib_cache_exception_NoSuchCache $e) {
			$this->cacheInstance = $GLOBALS['typo3CacheFactory']->create(
				'sfbanners_cache',
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['frontend'],
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['backend'],
				$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['options']
			);
		}
	}

	/**
	 * Click Action for a banner
	 *
	 * @param Tx_SfBanners_Domain_Model_Banner $banner
	 * @return void
	 */
	public function clickAction(Tx_SfBanners_Domain_Model_Banner $banner) {
		$banner->increaseClicks();
		$this->bannerRepository->update($banner);
		$this->redirectToURI($banner->getLinkUrl());
	}

	/**
	 * Show action
	 *
	 * @return void
	 */
	public function showAction() {
		$uniqueid = strtolower(substr(base64_encode(sha1(microtime())),0,9));
		$stringToHash = $GLOBALS['TSFE']->id . $this->settings['category'] . $this->settings['startingPoint'] .
			$this->settings['displayMode'];
		$hmac = $this->hashService->generateHmac($stringToHash);

		$this->view->assign('pid', $GLOBALS['TSFE']->id);
		$this->view->assign('categories', $this->settings['category']);
		$this->view->assign('startingPoint', $this->settings['startingPoint']);
		$this->view->assign('displayMode', $this->settings['displayMode']);
		$this->view->assign('typeNum', $this->settings['ajaxPageTypeNum']);
		$this->view->assign('uniqueid', $uniqueid);
		$this->view->assign('hmac', $hmac);

		/* Find all banners and add additional CSS */
		$banners = $this->bannerRepository->findAll();
		$cssFile = $this->bannerService->getAdditionalCssFile($banners);

		if ($cssFile != '') {
			$GLOBALS['TSFE']->getPageRenderer()->addCssFile($cssFile, 'stylesheet', 'all', '', TRUE);
		}
	}

	/**
	 * Returns banners for the given parameters if given Hmac validation succeeds
	 *
	 * @param string $categories
	 * @param string $startingPoint
	 * @param string $displayMode
	 * @param int $currentPageUid
	 * @param string $hmac
	 * @return string
	 */
	public function getBannersAction($categories = '', $startingPoint = '', $displayMode = 'all', $currentPageUid = 0,
									$hmac = '') {
		$compareString = $currentPageUid . $categories . $startingPoint . $displayMode;

		if ($this->hashService->validateHmac($compareString, $hmac)) {
			/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
			$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
			$demand->setCategories($categories);
			$demand->setStartingPoint($startingPoint);
			$demand->setDisplayMode($displayMode);
			$demand->setCurrentPageUid($currentPageUid);

			/* Get banners */
			$banners = $this->bannerRepository->findDemanded($demand);

			/* Update Impressions */
			$this->bannerRepository->updateImpressions($banners);

			/* Collect identifier based on uids for all banners */
			$ident = $GLOBALS['TSFE']->id;
			foreach ($banners as $banner) {
				$ident .= $banner->getUid();
			}

			if (FALSE === ($ret = $GLOBALS['typo3CacheManager']->getCache('sfbanners_cache')->get(sha1($ident)))) {
				$this->view->assign('banners', $banners);
				$this->view->assign('settings', $this->settings);
				$ret = $this->view->render();

				// Save value in cache
				$GLOBALS['typo3CacheManager']->getCache('sfbanners_cache')->set(sha1($ident), $ret, array('sf_banners'),
					$this->settings['cacheLifetime']);
			}
		} else {
			$ret = Tx_Extbase_Utility_Localization::translate('wrong_hmac', 'SfBanners');
		}
		return $ret;
	}

}
?>