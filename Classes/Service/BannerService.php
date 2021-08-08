<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Banner Service
 */
class BannerService
{
    /**
     * Returns a string with additional CSS for the given banners
     *
     * @param QueryResultInterface $banners Banners
     * @return string
     */
    public function getAdditionalCss(QueryResultInterface $banners): string
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
     * @param QueryResultInterface $banners Banners
     * @return string
     */
    public function getAdditionalCssFile(QueryResultInterface $banners): string
    {
        $filename = '';
        $css = $this->getAdditionalCss($banners);
        if ($css !== '') {
            $filename = GeneralUtility::writeStyleSheetContentToTemporaryFile($css);
        }
        return $filename;
    }
}
