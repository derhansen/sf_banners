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
class Tx_SfBanners_Domain_Repository_BannerRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Disable the use of storage records, because the StoragePage can be set in the plugin
	 */
	public function initializeObject() {
		$this->defaultQuerySettings = $this->objectManager->create('Tx_Extbase_Persistence_Typo3QuerySettings');
		$this->defaultQuerySettings->setRespectStoragePage(FALSE);
     }

	/**
	 * Returns banners matching the given demand
	 *
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand
	 *
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findDemanded(Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		$query = $this->createQuery();

		$constraints = array();

		if ($demand->getStoragePage() != 0) {
			$pidList = t3lib_div::intExplode(',', $demand->getStoragePage(), TRUE);
			$constraints[]  = $query->in('pid', $pidList);
		}

		$query->matching($query->logicalAnd($constraints));
		return $query->execute();
	}
}
?>