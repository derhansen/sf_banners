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
 * HashService helper with compatibility layer for TYPO3 4.5 to 6.x.
 * Uses ExtBase Cryptography HashService to generate and validate a Hmac.
 *
 * @package sf_banners
 */
class Tx_SfBanners_Service_HashServiceHelper {

	/**
	 * @var Tx_Extbase_Security_Cryptography_HashService
	 */
	protected $hashService;

	/**
	 * Inject the hashService
	 *
	 * @param Tx_Extbase_Security_Cryptography_HashService $hashService
	 * @return void
	 */
	public function injectHashService (Tx_Extbase_Security_Cryptography_HashService $hashService) {
		$this->hashService = $hashService;
	}

	/**
	 * Generate a hash (HMAC) for a given string
	 *
	 * @param string $string The string for which a hash should be generated
	 * @return string The hash of the string
	 * @throws mixed if something else than a string was given as parameter
	 */
	public function generateHmac($string) {
		if (method_exists($this->hashService, 'generateHmac')) {
			$hmac = $this->hashService->generateHmac($string);
		} else {
			$hmac = $this->hashService->generateHash($string);
		}
		return $hmac;
	}

	/**
	 * Tests if a string $string matches the HMAC given by $hash.
	 *
	 * @param string $string The string which should be validated
	 * @param string $hmac The hash of the string
	 * @return boolean TRUE if string and hash fit together, FALSE otherwise.
	 */
	public function validateHmac($string, $hmac) {
		if (method_exists($this->hashService, 'validateHmac')) {
			$result = $this->hashService->validateHmac($string, $hmac);
		} else {
			$result = $this->hashService->validateHash($string, $hmac);
		}
		return $result;
	}

}
?>