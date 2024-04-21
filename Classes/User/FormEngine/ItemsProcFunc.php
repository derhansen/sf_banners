<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\User\FormEngine;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ItemsProcFunc
{
    /**
     * Itemsproc function for banner type. Adds HTML banner type, if current backend user is admin or if HTML
     * banners are enabled for non-admin users.
     */
    public function getRestrictedBannerTypes(array &$config): void
    {
        $allowHtmlBannerForNonAdmins = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get('sf_banners', 'allowHtmlBannerForNonAdmins');

        if ((bool)$allowHtmlBannerForNonAdmins || $this->getBackendUser()->isAdmin()) {
            $config['items'][] = [
                $this->getLanguageService()->sL('LLL:EXT:sf_banners/Resources/Private/Language/locallang_db.xlf:tx_sfbanners_domain_model_banner.type.html'),
                1,
            ];
        }
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
