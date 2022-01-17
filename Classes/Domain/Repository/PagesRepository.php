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

use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Class PagesRepository
 * @package BERGWERK\BwrkOnepage\Domain\Repository
 */
class PagesRepository extends Repository
{
    /**
     * @param int $pageUid
     * @param string $sorting
     * @return array|QueryResultInterface
     */
    public function findByPid($pageUid, $sorting)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings(
            [
                // Order by Flexform selection
                $sorting => QueryInterface::ORDER_ASCENDING
            ]
        );
        $constraints = [
            $query->equals('pid', $pageUid),
            $query->equals('doktype', 1)
        ];
        $query->matching(
            $query->logicalAnd($constraints)
        );
        return $query->execute();
    }
}