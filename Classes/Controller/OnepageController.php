<?php
namespace BERGWERK\BwrkOnepage\Controller;


/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * ************************************************************* */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class OnepageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
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

    public function showOnepageAction()
    {
        $conf = $this->settings;
        $pages = $conf['pages'];

        if(strlen($pages) > 0)
        {
            $pageIds = explode(',', $pages);
            $fullArray = array();

            $cObj = $this->configurationManager->getContentObject();
            $cObjData = $cObj->data;
            $this->view->assign('cid', $cObjData['uid']);


            if(count($pageIds) > 0)
            {
                if(strlen($pageIds[0]) > 0)
                {
                    $i=0;
                    foreach($pageIds as $pageId)
                    {
                        $items = $this->contentRepository->getContentByPid($pageId);
                        $page = $this->pagesRepository->findByUid($pageId);

                        $j=0;
                        $tmpJ = array();
                        foreach ($items as $item)
                        {
                            $tmpJ[$j] = array(
                                'uid' => $item->getUid(),
                                'pid' => $item->getPid(),
                                'header' => $item->getHeader(),
                                'sorting' => $item->getSorting(),
                            );

                            $j++;
                        }
                        $fullArray[$i]['pid'] = $pageId;
                        $fullArray[$i]['title'] = $page->getTitle();
                        $fullArray[$i]['tab'] = $tmpJ;

                        $i++;
                    }
                    $this->view->assign('fullArray', $fullArray);
                }
            }
        }
    }
}