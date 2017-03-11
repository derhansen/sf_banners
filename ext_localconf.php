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
