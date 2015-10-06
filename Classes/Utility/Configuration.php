<?php
namespace BERGWERK\BwrkOnepage\Utility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

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
        if(!empty($extName)) $extKey = $extName;

        return unserialize($t3conf['EXT']['extConf'][$extKey]);
    }
}