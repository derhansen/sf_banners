<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'type' => 'type',
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
        'typeicon_classes' => [
            'default' => 'ext-sfbanners-banner'
        ],
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, type, 
            category, assets, margin_top, margin_right, margin_bottom, margin_left, html, 
            impressions_max, clicks_max, impressions, clicks, excludepages, recursive',
    ],
    'palettes' => [
        'paletteMargins' => ['showitem' => 'margin_top, margin_right, margin_bottom, margin_left'],
        'paletteVisibility' => ['showitem' => 'starttime, endtime'],
        'paletteLanguage' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
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
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
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
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'description' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'type' => [
            'exclude' => 1,
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
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => 'required',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'assets' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.assets',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'assets',
                [
                    'foreign_match_fields' => [
                        'fieldname' => 'assets',
                        'tablenames' => 'tx_sfbanners_domain_model_banner',
                        'table_local' => 'sys_file',
                    ],
                    'foreign_types' => [
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '--palette--;LLL:LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette,
                                      --palette--;;imageoverlayPalette,
                                      --palette--;;filePalette'
                        ],
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                        --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                        --palette--;;filePalette'
                            ],
                        ],
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                    'minitems' => 0,
                    'maxitems' => 1,
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'margin_top' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_top',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 4,
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'margin_right' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_right',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 4,
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'margin_bottom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_bottom',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 4,
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'margin_left' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.margin_left',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 4,
                'range' => ['lower' => 0, 'upper' => 1000],
                'eval' => 'int',
            ]
        ],
        'html' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.html',
            'config' => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 10,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'impressions_max' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.impressions_max',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'int',
            ]
        ],
        'clicks_max' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.clicks_max',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'int',
            ]
        ],
        'impressions' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.impressions',
            'config' => [
                'type' => 'none',
                'size' => 10,
                'default' => 0,
            ]
        ],
        'clicks' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.clicks',
            'config' => [
                'type' => 'none',
                'size' => 10,
                'default' => 0,
            ]
        ],
        'excludepages' => [
            'exclude' => 1,
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
            'showitem' => 'type, title, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.image,assets,--palette--;;paletteMargins,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages, recursive,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.language, --palette--;;paletteLanguage,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.access, hidden,--palette--;;paletteVisibility,
		'
        ],
        '1' => [
            'showitem' => 'type, title, description,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.html,html,--palette--;;paletteMargins,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages, recursive,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.language, --palette--;;paletteLanguage,
			--div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.access, hidden,--palette--;;paletteVisibility,
		'
        ]
    ],
];
