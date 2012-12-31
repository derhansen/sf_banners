<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Banners',
	array(
		'Category' => '',
		'Banner' => 'list',
		
	),
	// non-cacheable actions
	array(
		'Category' => '',
		'Banner' => '',
		
	)
);

?>