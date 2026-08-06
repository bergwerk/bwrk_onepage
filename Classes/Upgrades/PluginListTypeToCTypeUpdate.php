<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace BERGWERK\BwrkOnepage\Upgrades;

use TYPO3\CMS\Core\Attribute\UpgradeWizard;
use TYPO3\CMS\Core\Upgrades\AbstractListTypeToCTypeUpdate;

/**
 * Migrates existing "BERGWERK Onepage Viewer" content elements from the removed
 * CType "list" + list_type "bwrkonepage_pi1" combination to the dedicated
 * CType "bwrkonepage_pi1" introduced for TYPO3 v14.
 */
#[UpgradeWizard('bwrkOnepagePluginListTypeToCTypeUpdate')]
final class PluginListTypeToCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'bwrkonepage_pi1' => 'bwrkonepage_pi1',
        ];
    }

    public function getTitle(): string
    {
        return 'Migrate BERGWERK Onepage Viewer plugin to its own content type';
    }

    public function getDescription(): string
    {
        return 'TYPO3 v14 removed the "Plugin" (list) content element and its list_type subtypes. '
            . 'This wizard migrates existing "BERGWERK Onepage Viewer" content elements, and related '
            . 'backend user group permissions, from list_type "bwrkonepage_pi1" to the new CType "bwrkonepage_pi1".';
    }
}
