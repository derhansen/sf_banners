<?php
namespace DERHANSEN\SfBanners\Service;

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

use TYPO3\CMS\Frontend\Page\PageGenerator;

/**
 * Banner Service
 *
 * @author Torben Hansen <derhansen@gmail.com>
 */
class BannerService
{

    /**
     * Returns a string with additional CSS for the given banners
     *
     * @param array $banners Banners
     * @return string
     */
    public function getAdditionalCss($banners)
    {
        $ret = '';
        foreach ($banners as $banner) {
            /** @var \DERHANSEN\SfBanners\Domain\Model\Banner $banner */
            if ($banner->getMarginTop() > 0 || $banner->getMarginRight() > 0 ||
                $banner->getMarginBottom() > 0 || $banner->getMarginLeft() > 0
            ) {
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
    public function getAdditionalCssLink($banners)
    {
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
    public function getAdditionalCssFile($banners)
    {
        $css = $this->getAdditionalCss($banners);
        $filename = '';
        if ($css != '') {
            $filename = PageGenerator::inline2TempFile($css, 'css');
        }
        return $filename;
    }
}
