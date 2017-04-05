<?php
namespace BERGWERK\BwrkOnepage\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Georg Dümmler <gd@bergwerk.ag>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Class CacheUtility
 * @package BERGWERK\BwrkOnepage\Utility
 */
class CacheUtility extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     */
    protected $_configurationManager;

    /**
     * @var string
     */
    protected $_extKey;

    /**
     * @var \TYPO3\CMS\Extbase\Mvc\Request
     */
    protected $_request;

    /**
     * CacheUtility constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_extKey = GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName);

        $this->_request = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Mvc\\Request');
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        $this->_configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
    }

    /**
     * @param null $hashVars
     * @return bool|mixed
     */
    public function getCache ($hashVars = null )
    {
        $cacheID = $this->getCacheID(array($hashVars));
        $data = PageRepository::getHash($cacheID);
        if(!$data) return false;

        return unserialize($data);
    }


    /**
     * @param null $data
     * @param null $hashVars
     * @return null
     */
    public function setCache ($data = null, $hashVars = null )
    {
        $lifetime = mktime(23,59,59) + 1 - time();
        $cacheID = $this->getCacheID(array($hashVars));

        PageRepository::storeHash( $cacheID, serialize($data), $this->_extKey.'_cache', $lifetime );
        return $data;
    }

    /**
     * @param null $hashVars
     * @return string
     */
    private function getCacheID ($hashVars = null )
    {
        $additionalHashVars = array(
            'pid'       => $GLOBALS['TSFE']->id,
            'lang'      => $GLOBALS['TSFE']->sys_language_uid,
            'uid'       => $this->_configurationManager->getContentObject()->data['uid']
        );

        if(!is_null($GLOBALS['TSFE']->fe_user->user))
        {
            $additionalHashVars[] = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        }

        $additionalHashVars = array_merge($additionalHashVars, $this->_request->getArguments());

        $hashVars = array_merge($additionalHashVars, $hashVars);

        $hashString = join('|',array_values($hashVars)).join('|', array_keys($hashVars));

        return md5($hashString);
    }

}