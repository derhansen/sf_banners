<?php
defined('TYPO3_MODE') or die();

// Add an extra categories selection field to the banners table
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'sf_banners',
    'tx_sfbanners_domain_model_banner',
    'category',
    [
        'label' => 'LLL:EXT:sf_banners/Resources/Private/Language/locallang.xlf:tx_sfbanners_domain_model_banner.category',
        'exclude' => false
    ]
);
