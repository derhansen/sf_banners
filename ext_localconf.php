<?php
defined('TYPO3_MODE') or die();

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DERHANSEN.sf_banners',
        'Pi1',
        [
            'Banner' => 'show,getBanners,click',
        ],
        /* non-cacheable actions */
        [
            'Banner' => 'getBanners,click',
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

    /**
     * Register icons
     */
    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );
    $iconRegistry->registerIcon(
        'ext-sfbanners-banner',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:sf_banners/Resources/Public/Icons/tx_sfbanners_domain_model_banner.svg']
    );
});
