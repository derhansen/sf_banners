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
		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$demand->setCurrentPageUid($GLOBALS['TSFE']->id);
		$demand->setCategories($this->settings['category']);
		$demand->setDisplayMode($this->settings['displayMode']);
		$demand->setStartingPoint($this->settings['startingPoint']);

		$uniqueid = strtolower(substr(base64_encode(sha1(microtime())),0,9));

		$this->view->assign('uniqueid', $uniqueid);
		$this->view->assign('demand', $demand);
	}

	/**
	 * Returns banners for the given parameters
	 *
	 * @param string $categories
	 * @param string $startingPoint
	 * @param string $displayMode
	 * @param int $currentPageUid
	 *
	 * @return string
	 */
	public function getBannersAction($categories = '', $startingPoint = '', $displayMode = 'all', $currentPageUid = 0) {
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

		$this->view->assign('banners', $banners);
		return $this->view->render();
	}

}
?>