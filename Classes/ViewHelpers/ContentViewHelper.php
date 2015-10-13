<?php
namespace BERGWERK\BwrkOnepage\ViewHelpers;

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
 * Class ContentViewHelper
 * @package BERGWERK\BwrkOnepage\ViewHelpers
 */
class ContentViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $cObj;

    /**
     * Parse content element
     *
     * @param    int           UID des Content Element
     * @return   string        Geparstes Content Element
     */
    public function render($uid) {
        $this->cObj = $this->configurationManager->getContentObject();

        $conf = array(
            'tables' => 'tt_content',
            'source' => $uid,
            'dontCheckPid' => 1
        );

        return $this->cObj->RECORDS($conf);
    }
}