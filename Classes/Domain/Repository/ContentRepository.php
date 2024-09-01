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

namespace BERGWERK\BwrkOnepage\Domain\Repository;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class ContentRepository
 * @package BERGWERK\BwrkOnepage\Domain\Repository
 */
class ContentRepository extends Repository
{

    /**
     * Initializes the repository.
     *
     * @return void
     * @see \TYPO3\CMS\Extbase\Persistence\Repository::initializeObject()
     */
    public function initializeObject(): void
    {
        /** @var QuerySettingsInterface $querySettings */
        $querySettings = $this->objectManager->get(QuerySettingsInterface::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param int $pid
     * @return array|QueryResultInterface
     */
    public function getContentByPid($pid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $constraints = [
            $query->equals("pid", $pid)
        ];

        if (ExtensionManagementUtility::isLoaded('gridelements')) {
            $constraints[] = $query->equals('tx_gridelements_container', 0);
        }
        if (ExtensionManagementUtility::isLoaded('container')) {
            $constraints[] = $query->equals('tx_container_parent', 0);
        }
        if (ExtensionManagementUtility::isLoaded('flux')) {
            $constraints[] = $query->equals('tx_flux_parent', 0);
        }

        $query->matching(
            $query->logicalAnd(
                $constraints
            )
        );

        return $query->execute();
    }

    /**
     * @param int $pid
     * @return array|QueryResultInterface
     */
    public function findByPid($pid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->equals('pid', $pid)
        );
        return $query->execute();
    }

}