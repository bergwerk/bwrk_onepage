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

namespace BERGWERK\BwrkOnepage\Utility;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class Configuration
 * @package BERGWERK\BwrkOnepage\Utility
 */
class Configuration
{
    const EXT_KEY = 'bwrk_onepage';

    /**
     * @return array
     */
    public static function getExtConf()
    {
        return self::findExtConf(self::EXT_KEY);
    }

    /**
     * @return TypoScriptFrontendController
     */
    public static function getTsfe()
    {
        return $GLOBALS['TSFE'];
    }

    public static function getTypo3ConfVars()
    {
        return $GLOBALS['TYPO3_CONF_VARS'];
    }

    /**
     * @param string $extName
     * @return array
     */
    protected static function findExtConf($extName = '')
    {
        $t3conf = self::getTypo3ConfVars();

        $extKey = self::EXT_KEY;
        if (!empty($extName)) {
            $extKey = $extName;
        }

        return unserialize($t3conf['EXT']['extConf'][$extKey]);
    }
}