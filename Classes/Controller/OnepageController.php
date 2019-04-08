<?php
namespace BERGWERK\BwrkOnepage\Controller;

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
 * @author    Georg Dümmler <gd@bergwerk.ag>
 * @package    TYPO3
 * @subpackage    bwrk_onepage
 ***************************************************************/

use BERGWERK\BwrkOnepage\Domain\Model\Pages;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Class OnepageController
 * @package BERGWERK\BwrkOnepage\Controller
 */
class OnepageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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
     * @var \BERGWERK\BwrkOnepage\Domain\Repository\ContentRepository
     * @inject
     */
    protected $contentRepository;

    /**
     * @var \BERGWERK\BwrkOnepage\Domain\Repository\PagesRepository
     * @inject
     */
    protected $pagesRepository;

    /**
     * @var \BERGWERK\BwrkOnepage\Utility\CacheUtility
     * @inject
     */
    protected $cacheUtility;

    /**
     * Initializes the controller before invoking an action method.
     *
     * Override this method to solve tasks which all actions have in
     * common.
     *
     * @return void
     * @api
     */
    protected function initializeAction()
    {
        $this->extKey = GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName);
        $this->languageUid = $GLOBALS['TSFE']->sys_language_uid;
    }

    public function showAction()
    {
        $cObj = $this->configurationManager->getContentObject();
        $cObjData = $cObj->data;
        $pages = $this->getPages($cObjData['pid']);

        $cacheIdentifier = md5($cObjData['uid'] . '_' . implode(',', $pages) . $GLOBALS['TSFE']->id . $this->actionMethodName);
        $cachedHtmlOutput = $this->cacheUtility->getCache($cacheIdentifier);

        // deactivate cache on develope mode
        if(GeneralUtility::getApplicationContext()->isDevelopment()) $cachedHtmlOutput = false;

        if (!$cachedHtmlOutput) {
            $object = array();

            if (count($pages) > 0) {
                if (strlen($pages[0]) > 0) {
                    $i = 0;
                    foreach ($pages as $pageId) {
                        /** @var Pages $page */
                        $page = $this->pagesRepository->findByUid($pageId);
                        if (is_null($page)) continue;

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
        $pages = explode(',', $this->settings['pages']);
        $sorting = $this->settings['pagesOrdering'] ? $this->settings['pagesOrdering'] : 'uid';
        if ((boolean)$this->settings['allSubPages']) {
            /** @var Pages[] $pagesArray */
            $pages = array();
            $pagesArray = $this->pagesRepository->findByPid($pageUid, $sorting);
            foreach ($pagesArray as $page) {
                $pages[] = $page->getUid();
            }
        }
        return $pages;
    }
}
