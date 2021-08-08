<?php
defined('TYPO3') or die();

/**
 * Register plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sf_banners',
    'Pi1',
    'LLL:EXT:sf_banners/Resources/Private/Language/locallang.xlf:plugin_title'
);

/**
 * Add Flexform for plugin
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sfbanners_pi1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'sfbanners_pi1',
    'FILE:EXT:sf_banners/Configuration/Flexforms/Flexform_plugin.xml'
);

/**
 * Remove unused fields
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sfbanners_pi1'] = 'layout,recursive,select_key,pages';

/**
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'sf_banners',
    'Configuration/TypoScript',
    'Banner Management'
);
