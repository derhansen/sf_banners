<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Pi1',
    'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:plugin_title'
);

/* Add Flexform */
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,
    'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexforms/Flexform_plugin.xml');

/* Remove unused fields */
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key';

/* Add default Typoscript */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript',
    'Banner Management');

if (TYPO3_MODE == 'BE') {
    /* Add Plugin to wizzard */
    $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'][$pluginSignature . '_wizicon'] =
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Private/Php/class.' . $_EXTKEY . '_wizicon.php';
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sfbanners_domain_model_category',
    'EXT:sf_banners/Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_category.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sfbanners_domain_model_category');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sfbanners_domain_model_banner',
    'EXT:sf_banners/Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_banner.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sfbanners_domain_model_banner');
