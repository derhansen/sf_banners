<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_sfbanners_domain_model_banner'] = array(
	'ctrl' => $TCA['tx_sfbanners_domain_model_banner']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, type, category, image, margin_top, margin_right, margin_bottom, margin_left, alttext',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, description, type, category, image, margin_top, margin_right, margin_bottom, margin_left, alttext,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_sfbanners_domain_model_banner',
				'foreign_table_where' => 'AND tx_sfbanners_domain_model_banner.pid=###CURRENT_PID### AND tx_sfbanners_domain_model_banner.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.description',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'type' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.type.image', 0),
					array('LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.type.html', 1),
					array('LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.type.flash', 2),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required'
			),
		),
		'category' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.category',
			'config' => array(
				'type' => 'select',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'parentField' => 'parent',
					'appearance' => array(
						'expandAll' => true,
						'showHeader' => true,
					),
				),
				'MM' => 'tx_sfbanners_domain_model_banner_category_mm',
				'foreign_table' => 'tx_sfbanners_domain_model_category',
				'foreign_table_where' => ' ORDER BY tx_sfbanners_domain_model_category.sorting ASC',
				'minitems' => 0,
				'maxitems' => 5,
			),
		),
		'image' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.image',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'uploadfolder' => 'uploads/tx_sfbanners',
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'margin_top' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.margin_top',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'margin_right' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.margin_right',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'margin_bottom' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.margin_bottom',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'margin_left' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.margin_left',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'range' => Array ('lower'=>0,'upper'=>1000),
				'eval' => 'int,nospace',
			)
		),
		'alttext' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.alttext',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),

	),
);

?>