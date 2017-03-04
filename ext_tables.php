<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sfbanners_domain_model_category',
    'EXT:sf_banners/Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_category.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sfbanners_domain_model_category');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sfbanners_domain_model_banner',
    'EXT:sf_banners/Resources/Private/Language/locallang_csh_tx_sfbanners_domain_model_banner.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sfbanners_domain_model_banner');
