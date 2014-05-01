<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DERHANSEN.' . $_EXTKEY,
	'Pi1',
	array(
		'Banner' => 'show,getBanners,click',
	),
	/* non-cacheable actions */
	array(
		'Banner' => 'getBanners,click',
	)
);

// Register cache 'sfbanners_cache'
if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache'])) {
	$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['sfbanners_cache'] = array();
}
