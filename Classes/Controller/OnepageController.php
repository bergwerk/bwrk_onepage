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

namespace BERGWERK\BwrkOnepage\Controller;

use BERGWERK\BwrkOnepage\Domain\Model\Pages;
use BERGWERK\BwrkOnepage\Domain\Repository\ContentRepository;
use BERGWERK\BwrkOnepage\Domain\Repository\PagesRepository;
use BERGWERK\BwrkOnepage\Utility\CacheUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class OnepageController
 * @package BERGWERK\BwrkOnepage\Controller
 */
class OnepageController extends ActionController
{
    /**
     * @var string
     */
    protected $extKey;

    /**
     * @var int
     */
    protected $languageUid;

    /**
     * @var ContentRepository
     */
    protected $contentRepository;

    /**
     * @var PagesRepository
     */
    protected $pagesRepository;

    /**
     * @var CacheUtility
     */
    protected $cacheUtility;

    /**
     * Inject a content repository to enable DI
     *
     * @param ContentRepository $contentRepository
     */
    public function injectContentRepository(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    /**
     * Inject a page repository to enable DI
     *
     * @param PagesRepository $pagesRepository
     */
    public function injectPagesRepository(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }

    /**
     * Inject CacheUtility to enable DI
     *
     * @param CacheUtility $cacheUtility
     */
    public function injectCacheUtility(CacheUtility $cacheUtility)
    {
        $this->cacheUtility = $cacheUtility;
    }

    /**
     * Initializes the controller before invoking an action method.
     *
     * Override this method to solve tasks which all actions have in
     * common.
     *
     * @return void
     * @throws AspectNotFoundException
     * @api
     */
    protected function initializeAction()
    {
        $this->extKey = GeneralUtility::camelCaseToLowerCaseUnderscored('BwrkOnepage');
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $this->languageUid = $languageAspect->getId();
    }

    public function showAction()
    {
        $cObj = $this->configurationManager->getContentObject();
        $cObjData = $cObj->data;
        $pages = $this->getPages($cObjData['pid']);

        $cacheIdentifier = md5(
            $cObjData['uid'] . '_' . implode(',', $pages) . $GLOBALS['TSFE']->id . $this->actionMethodName
        );
        $cachedHtmlOutput = $this->cacheUtility->getCache($cacheIdentifier);

        // deactivate cache on develope mode
        if (Environment::getContext()->isDevelopment()) {
            $cachedHtmlOutput = false;
        }

        if (!$cachedHtmlOutput) {
            $object = [];

            if (count($pages) > 0) {
                if ($pages[0] != '') {
                    $i = 0;
                    foreach ($pages as $pageId) {
                        /** @var Pages $page */
                        $page = $this->pagesRepository->findByUid($pageId);
                        if (is_null($page)) {
                            continue;
                        }

                        $contentElements = $this->contentRepository->getContentByPid($page->getUid());

                        $object[$i]['uid'] = $page->getUid();
                        $object[$i]['pid'] = $pageId;
                        $object[$i]['title'] = $page->getTitle();
                        $object[$i]['sectionClass'] = $page->getTxBwrkonepageSectionclass();
                        $object[$i]['hideSectionMenu'] = $page->getTxBwrkonepageHidesectionmenu();
                        $object[$i]['contentElements'] = $contentElements;

                        $i++;
                    }
                }
            }

            $this->view->assign('cid', $cObjData['uid']);
            $this->view->assign('settings', $this->settings);
            $this->view->assign('object', $object);

            $htmlOutput = $this->view->render();

            $this->cacheUtility->setCache($htmlOutput, $cacheIdentifier);
            return $htmlOutput;
        }
        return $cachedHtmlOutput;
    }

    private function getPages($pageUid)
    {
        if ($this->settings['pages']) {
            $pages = explode(',', $this->settings['pages']);
        }
        $sorting = $this->settings['pagesOrdering'] ?: 'uid';
        if ((boolean)$this->settings['allSubPages']) {
            /** @var Pages[] $pagesArray */
            $pages = [];
            $pagesArray = $this->pagesRepository->findByPid($pageUid, $sorting);
            foreach ($pagesArray as $page) {
                $pages[] = $page->getUid();
            }
        }
        return $pages;
    }
}
