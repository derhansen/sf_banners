<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend;
use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'sf_banners',
        'Pi1',
        [
            \DERHANSEN\SfBanners\Controller\BannerController::class => 'show,getBanners,click',
        ],
        /* non-cacheable actions */
        [
            \DERHANSEN\SfBanners\Controller\BannerController::class => 'getBanners,click',
        ]
    );

    // Register cache 'sfbanners_cache'
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache'] ??= [];
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['frontend'] ??= VariableFrontend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['backend'] ??= Typo3DatabaseBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['groups'] ??= ['pages', 'all'];
});
