<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_sfbanners_domain_model_banner'] = array(
	'ctrl' => $TCA['tx_sfbanners_domain_model_banner']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, type, category, image, margin_top, margin_right, margin_bottom, margin_left, alttext, link, html, flash, flash_width, flash_height, flash_wmode, flash_allow_script_access, impressions_max, clicks_max, impressions, clicks, excludepages',
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 0,
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
			'exclude' => 0,
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
			'exclude' => 0,
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
			'exclude' => 0,
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
		'link' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.link',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'type' => 'popup',
						'title' => 'Link',
						'icon' => 'link_popup.gif',
						'script' => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
		'html' => Array (
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.html',
			'config' => Array (
				'type' => 'text',
				'cols' => '60',
				'rows' => '10',
			)
		),
		'flash' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.flash',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'swf',
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'uploadfolder' => 'uploads/tx_sfbanners',
				'show_thumbs' => 0,
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'flash_width' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.flash.width',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'eval' => 'int,nospace',
			)
		),
		'flash_height' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.flash.height',
			'config' => Array (
				'type' => 'input',
				'size' => '5',
				'max' => '4',
				'eval' => 'int,nospace',
			)
		),
		'flash_wmode' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.flash.wmode',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'flash_allow_script_access' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.flash.allowScriptAccess',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			),
		),
		'impressions_max' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.impressions_max',
			'config' => Array (
				'type' => 'input',
				'size' => '10',
				'eval' => 'int,nospace',
			)
		),
		'clicks_max' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.clicks_max',
			'config' => Array (
				'type' => 'input',
				'size' => '10',
				'eval' => 'int,nospace',
			)
		),
		'impressions' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.impressions',
			'config' => Array (
				'type' => 'none',
				'size' => '10',
			)
		),
		'clicks' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.clicks',
			'config' => Array (
				'type' => 'none',
				'size' => '10',
			)
		),
		'excludepages' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.excludepages',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 4,
				'minitems' => 0,
				'maxitems' => 100,
				'MM' => 'tx_sfbanners_domain_model_banner_excludepages_mm',
				'foreign_table' => 'pages',
			)
		),
	),
	'types' => array(
		'0' => array(
			'showitem' => 'l10n_parent,l10n_diffsource,title;;paletteCore;;1-1-1, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.image,image;;paletteMargins;;1-1-1,alttext,link,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.visibility, hidden;;paletteVisibility;;1-1-1,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
		'),
		'1' => array(
			'showitem' => 'l10n_parent,l10n_diffsource,title;;paletteCore;;1-1-1, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.html,html;;paletteMargins;;1-1-1,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.visibility, hidden;;paletteVisibility;;1-1-1,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
		'),
		'2' => array(
			'showitem' => 'l10n_parent,l10n_diffsource,title;;paletteCore;;1-1-1, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.flash,flash;;paletteMargins;;1-1-1,flash_width,flash_height, flash_wmode, flash_allow_script_access, link,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.visibility, hidden;;paletteVisibility;;1-1-1,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xml:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
		'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
		'paletteCore' => array(
			'showitem' => 'type, sys_language_uid',
			'canNotCollapse' => TRUE,
		),
		'paletteMargins' => array(
			'showitem' => 'margin_top, margin_right, margin_bottom, margin_left',
			'canNotCollapse' => TRUE,
		),
		'paletteVisibility' => array(
			'showitem' => 'starttime, endtime',
			'canNotCollapse' => TRUE,
		),
	),

);

?>