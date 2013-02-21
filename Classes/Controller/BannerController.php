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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
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

		/* Get banners */
		$banners = $this->bannerRepository->findDemanded($demand);

		/* Add additional CSS */
		$additionalCss = $this->bannerService->getAdditionalCssLink($banners);
		if ($additionalCss != '') {
			$this->response->addAdditionalHeaderData($additionalCss);
		}

		/* Update Impressions */
		$this->bannerRepository->updateImpressions($banners);

		$this->view->assign('banners', $banners);
	}

}
?>