<?php
namespace DERHANSEN\SfBanners\Service;
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

use TYPO3\CMS\Frontend\Page\PageGenerator;

/**
 * Banner Service
 *
 * @package sf_banners
 */
class BannerService {

	/**
	 * Returns a string with additional CSS for the given banners
	 *
	 * @param array $banners Banners
	 * @return string
	 */
	public function getAdditionalCss($banners) {
		$ret = '';
		foreach ($banners as $banner) {
			/** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
			if ($banner->getMarginTop() > 0 || $banner->getMarginRight() > 0 ||
				$banner->getMarginBottom() > 0 || $banner->getMarginLeft() > 0) {
				$bannerCss = '.banner-' . $banner->getUid() . ' { margin: ' . $banner->getMarginTop() .
					'px ' . $banner->getMarginRight() . 'px ' . $banner->getMarginBottom() . 'px ' .
					$banner->getMarginLeft() . 'px; }' . chr(10) . chr(13);
				$ret .= $bannerCss;
			}
		}
		return $ret;
	}

	/**
	 * Returns a <LINK> Tag with additional CSS for the banners
	 *
	 * @param array $banners Banners
	 * @return string
	 */
	public function getAdditionalCssLink($banners) {
		$filename = $this->getAdditionalCssFile($banners);
		$cssLink = '';
		if ($filename != '') {
			$cssLink = '<link rel="stylesheet" type="text/css" href="' . $filename . '" media="all" />';
		}
		return $cssLink;
	}

	/**
	 * Returns the filename of the additional CSS for the banners
	 *
	 * @param array $banners Banners
	 * @return string
	 */
	public function getAdditionalCssFile($banners) {
		$css = $this->getAdditionalCss($banners);
		$filename = '';
		if ($css != '') {
			$filename = PageGenerator::inline2TempFile($css, 'css');
		}
		return $filename;
	}
}
