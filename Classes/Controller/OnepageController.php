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

use Psr\Http\Message\ResponseInterface;
use BERGWERK\BwrkOnepage\Domain\Model\Pages;
use BERGWERK\BwrkOnepage\Domain\Repository\ContentRepository;
use BERGWERK\BwrkOnepage\Domain\Repository\PagesRepository;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Context\LanguageAspect;
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
    public function __construct(\BERGWERK\BwrkOnepage\Domain\Repository\ContentRepository $contentRepository, \BERGWERK\BwrkOnepage\Domain\Repository\PagesRepository $pagesRepository)
    {
        $this->contentRepository = $contentRepository;
        $this->pagesRepository = $pagesRepository;
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
        /** @var LanguageAspect $languageAspect */
        $languageAspect = GeneralUtility::makeInstance(Context::class)->getAspect('language');
        $this->languageUid = $languageAspect->getId();
    }

    /**
     * @return string
     */
    public function showAction(): ResponseInterface
    {
        // @extensionScannerIgnoreLine
        $cObjData = $this->request->getAttribute('currentContentObject')->data;
        $pages = $this->getPages($cObjData['pid']);
        $object = [];

        if (count($pages) > 0) {
            if ($pages[0] !== '') {
                $i = 0;
                foreach ($pages as $pageId) {
                    /** @var Pages $page */
                    $page = $this->pagesRepository->findByUid($pageId);

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

        $this->view->assignMultiple([
            'cid' => $cObjData['uid'],
            'settings' => $this->settings,
            'object' => $object,
        ]);

        return $this->htmlResponse($this->view->render());
    }

    /**
     * @param int $pageUid
     * @return array
     */
    private function getPages($pageUid): array
    {
        $pages = [];
        if (array_key_exists('pages', $this->settings)) {
            $pages = explode(',', $this->settings['pages']);
        }
        $sorting = $this->settings['pagesOrdering'] ?: 'uid';
        if ((boolean)$this->settings['allSubPages']) {
            /** @var Pages[] $pagesArray */
            $pagesArray = $this->pagesRepository->findByPid($pageUid, $sorting);
            foreach ($pagesArray as $page) {
                $pages[] = $page->getUid();
            }
        }
        return $pages;
    }
}
