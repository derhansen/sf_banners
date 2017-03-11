<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DERHANSEN.' . $_EXTKEY,
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
if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache'] = [];
}

if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['frontend'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['frontend'] = \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class;
}

if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['backend'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['backend'] = TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class;
}

// Set Cache groups
if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['groups'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache']['groups'] = ['pages', 'all'];
}