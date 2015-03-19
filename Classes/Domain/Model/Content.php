<?php

namespace BERGWERK\BwrkOnepage\Domain\Model;

/***************************************************************
 * Copyright notice
 *
 * (c) 2012 Klaus Heuer <klaus.heuer@t3-developer.com>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Class for the tt_content
 *
 * represents the Content Model
 *
 *
 */

/**
 * @scope prototype
 * @entity
 */
class Content extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
    /**
     * uid
     * @var int
     * @validate NotEmpty
     */
    protected $uid;

    /**
     * pid
     * @var int
     * @validate NotEmpty
     */
    protected $pid;


    /**
     * Returns the pid
     *
     * @return int $pid
     */
    public function getPid() {
        return $this->pid;
    }


    /**
     * colPos
     * @var int
     */
    protected $colPos;

    /**
     * @return mixed
     */
    public function getColPos()
    {
        return $this->colPos;
    }

    /**
     * @param mixed $colPos
     */
    public function setColPos($colPos)
    {
        $this->colPos = $colPos;
    }
}