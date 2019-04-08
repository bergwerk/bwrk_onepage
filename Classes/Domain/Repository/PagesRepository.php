<?php
namespace BERGWERK\BwrkOnepage\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Georg Dümmler <gd@bergwerk.ag>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author	Georg Dümmler <gd@bergwerk.ag>
 * @package	TYPO3
 * @subpackage	bwrk_onepage
 ***************************************************************/

/**
 * Class PagesRepository
 * @package BERGWERK\BwrkOnepage\Domain\Repository
 */
class PagesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findByPid($pageUid, $sorting)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings([
            // Order by Flexform selection
            $sorting => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ]);
        $query->matching(
            $query->logicalAnd(
                $query->equals('pid', $pageUid),
                $query->equals('doktype', 1)
            )
        );
        return $query->execute();
    }
}