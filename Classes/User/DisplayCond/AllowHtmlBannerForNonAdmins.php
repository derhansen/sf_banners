<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\User\DisplayCond;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Special TCA displayCond which decides, if HTML banners are available for non-admin users depending on
 * the configured extension setting `allowHtmlBannerForNonAdmins`
 */
class AllowHtmlBannerForNonAdmins
{
    public function isEnabled(): bool
    {
        if ($this->getBackendUser()->isAdmin()) {
            return true;
        }

        $allowHtmlBannerForNonAdmins = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get('sf_banners', 'allowHtmlBannerForNonAdmins');

        return (bool)$allowHtmlBannerForNonAdmins;
    }

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}