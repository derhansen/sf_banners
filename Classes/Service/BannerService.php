<?php
namespace DERHANSEN\SfBanners\Service;

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

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
     * Returns the filename of the additional CSS for the banners
     *
     * @param array $banners Banners
     * @return string
     */
    public function getAdditionalCssFile($banners)
    {
        $filename = '';
        $css = $this->getAdditionalCss($banners);
        if ($css !== '') {
            $filename = GeneralUtility::writeStyleSheetContentToTemporaryFile($css);
        }
        return $filename;
    }
}
