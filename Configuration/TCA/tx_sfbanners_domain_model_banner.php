<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
            'fe_group' => 'fe_group',
        ],
        'searchFields' => 'title,description,type,category,',
        'typeicon_classes' => [
            'default' => 'ext-sfbanners-banner',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'palettes' => [
        'paletteVisibility' => ['showitem' => 'starttime, endtime'],
        'paletteLanguage' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource'],
    ],
    'columns' => [
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'description' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
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
                        'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.type.image',
                        'value' => 0,
                    ],
                ],
                'itemsProcFunc' => 'DERHANSEN\SfBanners\User\FormEngine\ItemsProcFunc->getRestrictedBannerTypes',
                'size' => 1,
                'maxitems' => 1,
                'required' => true,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'assets' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.assets',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                ],
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'html' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.html',
            'displayCond' => 'USER:DERHANSEN\\SfBanners\\User\\DisplayCond\\AllowHtmlBannerForNonAdmins->isEnabled',
            'config' => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 10,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'category' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.category',
            'config' => [
                'type' => 'category',
            ],
        ],
        'impressions_max' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.impressions_max',
            'config' => [
                'type' => 'number',
                'size' => 10,
                'range' => [
                    'lower' => 0,
                ],
                'default' => 0,
            ],
        ],
        'clicks_max' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.clicks_max',
            'config' => [
                'type' => 'number',
                'size' => 10,
                'range' => [
                    'lower' => 0,
                ],
                'default' => 0,
            ],
        ],
        'impressions' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.impressions',
            'config' => [
                'type' => 'number',
                'size' => 10,
                'default' => 0,
                'readOnly' => true,
            ],
        ],
        'clicks' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.clicks',
            'config' => [
                'type' => 'number',
                'size' => 10,
                'default' => 0,
                'readOnly' => true,
            ],
        ],
        'excludepages' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.excludepages',
            'config' => [
                'type' => 'group',
                'allowed' => 'pages',
                'size' => 4,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_sfbanners_domain_model_banner_excludepages_mm',
                'foreign_table' => 'pages',
            ],
        ],
        'recursive' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.recursive',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => false,
                    ],
                ],
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
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, --palette--;;paletteLanguage,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden,--palette--;;paletteVisibility, fe_group,
            ',
        ],
        '1' => [
            'showitem' => 'type, title, description,
                --div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.html,html,--palette--;;paletteMargins,
                --div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.display, category, excludepages, recursive,
                --div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.limitations, impressions_max, clicks_max,
                --div--;LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.tabs.statistics, impressions, clicks,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, --palette--;;paletteLanguage,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden,--palette--;;paletteVisibility, fe_group,
            ',
        ],
    ],
];
