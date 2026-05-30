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
    'ext-sfbanners-plugin',
    'plugins',
    'LLL:EXT:sf_banners/Resources/Private/Language/locallang.xlf:plugin_description',
    'FILE:EXT:sf_banners/Configuration/Flexforms/Flexform_plugin.xml'
);

/**
 * Default TypoScript
 */
ExtensionManagementUtility::addStaticFile(
    'sf_banners',
    'Configuration/TypoScript',
    'Banner Management'
);
