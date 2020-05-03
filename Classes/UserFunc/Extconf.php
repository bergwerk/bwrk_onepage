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

namespace BERGWERK\BwrkOnepage\UserFunc;

use BERGWERK\BwrkOnepage\Utility\Configuration;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class Extconf
 * @package BERGWERK\BwrkOnepage\Utility
 */
class Extconf
{
    /**
     * @param string $lib
     * @return bool
     */
    public static function match($lib)
    {
        $extConf = Configuration::getExtConf();
        DebuggerUtility::var_dump($extConf);
        if (array_key_exists($lib, $extConf)) {
            if ((bool)$extConf[$lib]) {
                return true;
            }
        }
        return false;
    }
}