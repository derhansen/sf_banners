<?php
namespace DERHANSEN\SfBanners\Persistence;

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

use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

class RandomQueryResult extends QueryResult {

	/**
	 * Keeps track of, if records have been shuffled
	 */
	protected $shuffled = FALSE;

	/**
	 * Loads the objects this QueryResult is supposed to hold
	 *
	 * @return void
	 */
	protected function initialize() {
		parent::initialize();
		if (!$this->shuffled) {
			shuffle($this->queryResult);
			$this->shuffled = TRUE;
		}
	}
}

