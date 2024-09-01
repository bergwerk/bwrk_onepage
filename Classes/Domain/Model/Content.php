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

namespace BERGWERK\BwrkOnepage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * Class Content
 * @package BERGWERK\BwrkOnepage\Domain\Model
 */
class Content extends AbstractEntity
{

    /**
     * header
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $header;

    /**
     * sorting
     * @var int
     * @Extbase\Validate("NotEmpty")
     */
    protected $sorting;

    /**
     * _localizedUid
     *
     * @var string
     */
    protected $_localizedUid;


    /**
     * Returns the _localizedUid
     *
     * @return string $_localizedUid
     */
    public function get_localizedUid()
    {
        return $this->_localizedUid;
    }

    /**
     * Returns the header
     *
     * @return string $header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Returns the sorting
     *
     * @return int $sorting
     */
    public function getSorting()
    {
        return $this->sorting;
    }


}