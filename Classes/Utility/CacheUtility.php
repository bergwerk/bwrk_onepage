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

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class CacheUtility
 * @package BERGWERK\BwrkOnepage\Utility
 */
class CacheUtility extends ActionController
{
    /**
     * @var ConfigurationManager
     */
    protected $_configurationManager;

    /**
     * @var string
     */
    protected $_extKey;

    /**
     * @var Request
     */
    protected $_request;

    /**
     * CacheUtility constructor.
     */
    public function __construct()
    {
        $this->_extKey = GeneralUtility::camelCaseToLowerCaseUnderscored('BwrkOnepage');

        $this->_request = GeneralUtility::makeInstance(Request::class);
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->_configurationManager = $objectManager->get(ConfigurationManager::class);
    }

    /**
     * @param null $hashVars
     * @return bool|mixed
     * @throws NoSuchCacheException
     * @throws AspectNotFoundException
     */
    public function getCache($hashVars = null)
    {
        $cacheID = $this->getCacheID([$hashVars]);
        $data = self::getHash($cacheID);
        if (!$data) {
            return false;
        }

        return unserialize($data);
    }


    /**
     * @param null $data
     * @param null $hashVars
     * @return null
     */
    public function setCache($data = null, $hashVars = null)
    {
        $lifetime = mktime(23, 59, 59) + 1 - time();
        $cacheID = $this->getCacheID([$hashVars]);

        self::storeHash($cacheID, serialize($data), $this->_extKey . '_cache', $lifetime);
        return $data;
    }

    /**
     * @param null $hashVars
     * @return string
     * @throws AspectNotFoundException
     */
    private function getCacheID($hashVars = null)
    {
        $this->extKey = GeneralUtility::camelCaseToLowerCaseUnderscored('BwrkOnepage');
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $additionalHashVars = [
            'pid' => $GLOBALS['TSFE']->id,
            'lang' => $languageAspect->getId(),
            'uid' => $this->_configurationManager->getContentObject()->data['uid']
        ];

        if (!is_null($GLOBALS['TSFE']->fe_user->user)) {
            $additionalHashVars[] = $GLOBALS['TSFE']->fe_user->user['ses_id'];
        }

        $additionalHashVars = array_merge($additionalHashVars, $this->_request->getArguments());

        $hashVars = array_merge($additionalHashVars, $hashVars);

        $hashString = implode('|', array_values($hashVars)) . implode('|', array_keys($hashVars));

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
     * @throws NoSuchCacheException
     * @see storeHash()
     */
    public static function getHash($hash)
    {
        $hashContent = null;
        /** @var FrontendInterface $contentHashCache */
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
     * @throws NoSuchCacheException
     * @see getHash()
     */
    public static function storeHash($hash, $data, $ident, $lifetime = 0)
    {
        GeneralUtility::makeInstance(CacheManager::class)->getCache('cache_hash')->set(
            $hash,
            $data,
            ['ident_' . $ident],
            (int)$lifetime
        );
    }

}