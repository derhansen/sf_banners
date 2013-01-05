<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Torben Hansen <derhansen@gmail.com>, Skyfillers GmbH
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
 *
 * @package sf_banners
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_SfBanners_Controller_BannerController extends Tx_Extbase_MVC_Controller_ActionController {

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
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		//$banners = $this->bannerRepository->findAll();

		/** @var Tx_SfBanners_Domain_Model_BannerDemand $demand  */
		$demand = $this->objectManager->get('Tx_SfBanners_Domain_Model_BannerDemand');
		$demand->setStoragePage(8);

		$banners = $this->bannerRepository->findDemanded($demand);

		$this->view->assign('banners', $banners);
	}

}
?>