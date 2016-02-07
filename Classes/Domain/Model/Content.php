<?php
namespace BERGWERK\BwrkOnepage\Domain\Model;

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
 * Class Content
 * @package BERGWERK\BwrkOnepage\Domain\Model
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
     * header
     * @var string
     * @validate NotEmpty
     */
    protected $header;

    /**
     * sorting
     * @var int
     * @validate NotEmpty
     */
    protected $sorting;

    /**
     * _localizedUid
     *
     * @var string
     */
    protected $_localizedUid;

    /**
     * Returns the uid
     *
     * @return int $uid
     */
    public function getUid() {
        return $this->uid;
    }


    /**
     * Returns the _localizedUid
     *
     * @return string $_localizedUid
     */
    public function get_localizedUid() {
        return $this->_localizedUid;
    }

    /**
     * Returns the pid
     *
     * @return int $pid
     */
    public function getPid() {
        return $this->pid;
    }

    /**
     * Returns the header
     *
     * @return string $header
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * Returns the sorting
     *
     * @return int $sorting
     */
    public function getSorting() {
        return $this->sorting;
    }


}