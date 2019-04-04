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

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        $data = self::getHash($cacheID);
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

        self::storeHash( $cacheID, serialize($data), $this->_extKey.'_cache', $lifetime );
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

    /********************************
     *
     * Caching and standard clauses
     *
     ********************************/

    /**
     * Returns data stored for the hash string in the cache "cache_hash"
     * Can be used to retrieved a cached value, array or object
     * Can be used from your frontend plugins if you like. It is also used to
     * store the parsed TypoScript template structures.
     *
     * @param string $hash The hash-string which was used to store the data value
     * @return mixed The "data" from the cache
     * @see storeHash()
     */
    public static function getHash($hash)
    {
        $hashContent = null;
        /** @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $contentHashCache */
        $contentHashCache = GeneralUtility::makeInstance(CacheManager::class)->getCache('cache_hash');
        $cacheEntry = $contentHashCache->get($hash);
        if ($cacheEntry) {
            $hashContent = $cacheEntry;
        }
        return $hashContent;
    }

    /**
     * Stores $data in the 'cache_hash' cache with the hash key, $hash
     * and visual/symbolic identification, $ident
     *
     * Can be used from your frontend plugins if you like.
     *
     * @param string $hash 32 bit hash string (eg. a md5 hash of a serialized array identifying the data being stored)
     * @param mixed $data The data to store
     * @param string $ident Is just a textual identification in order to inform about the content!
     * @param int $lifetime The lifetime for the cache entry in seconds
     * @see getHash()
     */
    public static function storeHash($hash, $data, $ident, $lifetime = 0)
    {
        GeneralUtility::makeInstance(CacheManager::class)->getCache('cache_hash')->set($hash, $data, ['ident_' . $ident], (int)$lifetime);
    }

}