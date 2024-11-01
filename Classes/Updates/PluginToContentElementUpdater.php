<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "sf_banners" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace DERHANSEN\SfBanners\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard('sfBannersPluginToContentElementUpdate')]
class PluginToContentElementUpdater extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'sfbanners_pi1' => 'sfbanners_pi1',
        ];
    }

    public function getTitle(): string
    {
        return 'ext:sf_banners: Migrate plugins to content elements';
    }

    public function getDescription(): string
    {
        return 'Migrates existing plugin records and backend user permissions used by ext:banners';
    }
}
