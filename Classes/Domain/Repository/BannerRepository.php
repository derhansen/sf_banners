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
	 * @todo: include demands for banner (max impressions, max clicks, pages)
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

		if ($demand->getCategories() != 0) {
			$categoryConstraints = array();
			$categories = t3lib_div::intExplode(',', $demand->getCategories(), TRUE);
			foreach ($categories as $category) {
				$categoryConstraints[]  = $query->contains('category', $category);
			}
			if (count($categoryConstraints) > 0) {
				$constraints[] = $query->logicalOr($categoryConstraints);
			}
		}

		$query->matching($query->logicalAnd($constraints));
		$result = $this->getResult($query, $demand);
		return $result;
	}

	/**
	 * Returns the result of the query based on the given displaymode set in demand
	 *
	 * @param Tx_Extbase_Persistence_QueryInterface $query
	 * @param Tx_SfBanners_Domain_Model_BannerDemand $demand
	 *
	 * @return array|Tx_Extbase_Persistence_QueryResultInterface
	 */
	private function getResult(Tx_Extbase_Persistence_QueryInterface $query, Tx_SfBanners_Domain_Model_BannerDemand $demand) {
		$result = array();
		switch ($demand->getDisplayMode()) {
			case 0:
				$result = $query->execute();
				break;
			case 1:
				$backend = t3lib_div::makeInstance('Tx_Extbase_Persistence_Storage_Typo3DbBackend');
				$parameters = array();
				$statementParts = $backend->parseQuery($query, $parameters);
				$statementParts['orderings'][] = 'RAND()';
				$statement = $backend->buildQuery($statementParts, $parameters);
				$query->statement($statement, $parameters);
				$result = $query->execute();
				break;
			case 2:
				$rows = $query->execute()->count();
				$row_number = mt_rand(0, max(0, ($rows - 1)));
				$result = $query->setOffset($row_number)->setLimit(1)->execute();
				break;
		}
		return $result;
	}

	/** @todo: create method to update counter of banner */

	/** @todo: create method to update counter of clicks */

}
?>