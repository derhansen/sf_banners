<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

/**
 * Register plugin
 */
ExtensionUtility::registerPlugin(
    'sf_banners',
    'Pi1',
    'LLL:EXT:sf_banners/Resources/Private/Language/locallang.xlf:plugin_title',
    'ext-sfbanners-plugin'
);

/**
 * Add Flexform for plugin
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbanners_pi1'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:sf_banners/Configuration/Flexforms/Flexform_plugin.xml',
    'sfbanners_pi1'
);

$GLOBALS['TCA']['tt_content']['types']['sfbanners_pi1']['showitem'] = '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
            pi_flexform,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ';

/**
 * Default TypoScript
 */
ExtensionManagementUtility::addStaticFile(
    'sf_banners',
    'Configuration/TypoScript',
    'Banner Management'
);
