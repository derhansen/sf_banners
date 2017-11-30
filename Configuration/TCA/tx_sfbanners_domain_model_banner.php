<?php

$sfBannersConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sf_banners']);

if ($sfBannersConf['falMedia']) {
    $image = 'assets,';
    $link = '';
} else {
    $image = 'image,';
    $link = 'link,';
}

return [
    'ctrl' => [
        'title' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'type' => 'type',
        'dividers2tabs' => true,
        'sortby' => 'sorting',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,description,type,category,',
        'iconfile' => 'EXT:sf_banners/Resources/Public/Icons/tx_sfbanners_domain_model_banner.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, type, category, image, assets, margin_top, margin_right, margin_bottom, margin_left, alttext, link, html, flash, flash_width, flash_height, flash_wmode, flash_allow_script_access, impressions_max, clicks_max, impressions, clicks, excludepages, recursive',
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 0,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_sfbanners_domain_model_banner',
                'foreign_table_where' => 'AND tx_sfbanners_domain_model_banner.pid=###CURRENT_PID### AND tx_sfbanners_domain_model_banner.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'type' => [
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.type.image',
                        0
                    ],
                    [
                        'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.type.html',
                        1
                    ],
                    [
                        'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.type.flash',
                        2
                    ],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => 'required'
            ],
        ],
        'category' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.category',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => true,
                        'showHeader' => true,
                    ],
                ],
                'MM' => 'tx_sfbanners_domain_model_banner_category_mm',
                'foreign_table' => 'tx_sfbanners_domain_model_category',
                'foreign_table_where' => ' AND (tx_sfbanners_domain_model_category.sys_language_uid = 0 OR tx_sfbanners_domain_model_category.l10n_parent = 0) ORDER BY tx_sfbanners_domain_model_category.sorting ASC',
                'minitems' => 0,
                'maxitems' => 30,
            ],
        ],
        'image' => [
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.image',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
                'uploadfolder' => 'uploads/tx_sfbanners',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ]
        ],
        'assets' => [
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.assets',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'assets',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
                        'showPossibleLocalizationRecords' => 1,
                        'showRemovedLocalizationRecords' => 1,
                        'showAllLocalizationLink' => 1,
                        'showSynchronizationLink' => 1
                    ],
                    'foreign_types' => [
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_UNKNOWN => [
                            'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE   => [
                            'showitem' => '
                                --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                    ],
                    'minitems' => 0,
                    'maxitems' => 1,
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'margin_top' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_top',
            'config' => [
                'type' => 'input',
                'size' => '5',
                'max' => '4',
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'margin_right' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_right',
            'config' => [
                'type' => 'input',
                'size' => '5',
                'max' => '4',
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'margin_bottom' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_bottom',
            'config' => [
                'type' => 'input',
                'size' => '5',
                'max' => '4',
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'margin_left' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_left',
            'config' => [
                'type' => 'input',
                'size' => '5',
                'max' => '4',
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'alttext' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.alttext',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'link' => [
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.link',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'wizards' => [
                    'link' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                        'icon' => 'actions-wizard-link',
                        'module' => [
                            'name' => 'wizard_link',
                        ],
                        'JSopenParams' => 'height=800,width=600,status=0,menubar=0,scrollbars=1'
                    ]
                ]
            ]
        ],
        'html' => [
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.html',
            'config' => [
                'type' => 'text',
                'cols' => '60',
                'rows' => '10',
            ]
        ],
        'flash' => [
            'exclude' => 0,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.flash',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'allowed' => 'swf',
                'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
                'uploadfolder' => 'uploads/tx_sfbanners',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'fieldWizard' => [
                    'fileThumbnails' => [
                        'disabled' => true
                    ]
                ],
            ]
        ],
        'flash_width' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.flash.width',
            'config' => [
                'type' => 'input',
                'size' => '5',
                'max' => '4',
                'eval' => 'int',
            ]
        ],
        'flash_height' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.flash.height',
            'config' => [
                'type' => 'input',
                'size' => '5',
                'max' => '4',
                'eval' => 'int',
            ]
        ],
        'flash_wmode' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.flash.wmode',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'flash_allow_script_access' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.flash.allowScriptAccess',
            'config' => [
                'type' => 'input',
                'size' => 30,
            ],
        ],
        'impressions_max' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.impressions_max',
            'config' => [
                'type' => 'input',
                'size' => '10',
                'eval' => 'int',
            ]
        ],
        'clicks_max' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.clicks_max',
            'config' => [
                'type' => 'input',
                'size' => '10',
                'eval' => 'int',
            ]
        ],
        'impressions' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.impressions',
            'config' => [
                'type' => 'none',
                'size' => '10',
                'default' => 0,
                'setToDefaultOnCopy' => 1
            ]
        ],
        'clicks' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.clicks',
            'config' => [
                'type' => 'none',
                'size' => '10',
                'default' => 0,
                'setToDefaultOnCopy' => 1
            ]
        ],
        'excludepages' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.excludepages',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'size' => 4,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_sfbanners_domain_model_banner_excludepages_mm',
                'foreign_table' => 'pages',
            ]
        ],
        'recursive' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.recursive',
            'config' => [
                'type' => 'check',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'l10n_parent,l10n_diffsource,title,--palette--;;paletteCore, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.image,' . $image . ',--palette--;;paletteMargins,' . $link . '
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages, recursive,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.visibility, hidden,--palette--;;paletteVisibility,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
		'
        ],
        '1' => [
            'showitem' => 'l10n_parent,l10n_diffsource,title,--palette--;;paletteCore, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.html,html,--palette--;;paletteMargins,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages, recursive,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.visibility, hidden,--palette--;;paletteVisibility,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
		'
        ],
        '2' => [
            'showitem' => 'l10n_parent,l10n_diffsource,title,--palette--;;paletteCore, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.flash,flash,--palette--;;paletteMargins,flash_width,flash_height, flash_wmode, flash_allow_script_access, link,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages, recursive,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.visibility, hidden,--palette--;;paletteVisibility,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
		'
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
        'paletteCore' => [
            'showitem' => 'type, sys_language_uid',
        ],
        'paletteMargins' => [
            'showitem' => 'margin_top, margin_right, margin_bottom, margin_left',
        ],
        'paletteVisibility' => [
            'showitem' => 'starttime, endtime',
        ],
    ],

];
