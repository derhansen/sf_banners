<?php
namespace DERHANSEN\SfBanners\ViewHelpers\Format;
/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        *
 * Backported by Torben Hansen <derhansen@gmail.com> so this extension    *
 * can be used with TYPO3 4.5                                             *
 *                                                                        */

/**
 * Encodes the given string according to http://www.faqs.org/rfcs/rfc3986.html (applying PHPs rawurlencode() function)
 * @see http://www.php.net/manual/function.rawurlencode.php
 *
 * = Examples =
 *
 * <code title="default notation">
 * <f:format.urlencode>foo @+%/</f:format.urlencode>
 * </code>
 * <output>
 * foo%20%40%2B%25%2F (rawurlencode() applied)
 * </output>
 *
 * <code title="inline notation">
 * {text -> f:format.urlencode()}
 * </code>
 * <output>
 * Url encoded text (rawurlencode() applied)
 * </output>
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class UrlencodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Disable the escaping interceptor because otherwise the child nodes would be escaped before this view helper
	 * can decode the text's entities.
	 *
	 * @var boolean
	 */
	protected $escapingInterceptorEnabled = FALSE;

	/**
	 * Escapes special characters with their escaped counterparts as needed using PHPs rawurlencode() function.
	 *
	 * @param null $value
	 * @author Karsten Dambekalns <karsten@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
	 * @see http://www.php.net/manual/function.rawurlencode.php
	 *
	 * @return mixed|null|string
	 */
	public function render($value = NULL) {
		if ($value === NULL) {
			$value = $this->renderChildren();
		}
		if (!is_string($value)) {
			return $value;
		}
		return rawurlencode($value);
	}

}
