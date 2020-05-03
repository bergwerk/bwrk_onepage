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
 * Class Pages
 * @package BERGWERK\BwrkOnepage\Domain\Model
 */
class Pages extends AbstractEntity
{

    /**
     * title
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $title;

    /**
     * @var int
     */
    protected $txBwrkonepageSectionclass;

    /**
     * @var int
     */
    protected $txBwrkonepageHidesectionmenu;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getTxBwrkonepageSectionclass()
    {
        return $this->txBwrkonepageSectionclass;
    }

    /**
     * @param int $txBwrkonepageSectionclass
     */
    public function setTxBwrkonepageSectionclass($txBwrkonepageSectionclass)
    {
        $this->txBwrkonepageSectionclass = $txBwrkonepageSectionclass;
    }

    /**
     * @return int
     */
    public function getTxBwrkonepageHidesectionmenu()
    {
        return $this->txBwrkonepageHidesectionmenu;
    }

    /**
     * @param int $txBwrkonepageHidesectionmenu
     */
    public function setTxBwrkonepageHidesectionclass($txBwrkonepageHidesectionmenu)
    {
        $this->txBwrkonepageHidesectionmenu = $txBwrkonepageHidesectionmenu;
    }
}