<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Banners',
	'Display Banners'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Banner Management');

t3lib_extMgm::addLLrefForTCAdescr('tx_sfbanners_domain_model_category', 'EXT:sf_banners/Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_category.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_sfbanners_domain_model_category');
$TCA['tx_sfbanners_domain_model_category'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_category',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,parent,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_sfbanners_domain_model_category.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_sfbanners_domain_model_banner', 'EXT:sf_banners/Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_banner.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_sfbanners_domain_model_banner');
$TCA['tx_sfbanners_domain_model_banner'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,description,type,category,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Banner.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_sfbanners_domain_model_banner.gif'
	),
);

?>