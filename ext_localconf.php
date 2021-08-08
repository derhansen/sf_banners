<?php
defined('TYPO3') or die();

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
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache'] = [];
    }

    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['frontend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['frontend'] = \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class;
    }

    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['backend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['backend'] = TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class;
    }

    // Set Cache groups
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['groups'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['groups'] = ['pages', 'all'];
    }
});
