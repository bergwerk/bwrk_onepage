<?php
namespace BERGWERK\BwrkOnepage\Typo3Overrides;

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
 * Class TextMenuContentObject
 * @package BERGWERK\BwrkOnepage\Typo3Overrides
 */
class TextMenuContentObject extends \TYPO3\CMS\Frontend\ContentObject\Menu\TextMenuContentObject
{
    /**
     * @param string $item
     * @param int $key
     * @return string
     */
    public function extProc_beforeAllWrap($item, $key)
    {

        if (!empty($item)) {
            $pageId = $this->I['uid'];

            $dom = new \DOMDocument();
            $dom->loadHTML(mb_convert_encoding($item, 'HTML-ENTITIES', 'UTF-8'));

            $link = $dom->getElementsByTagName('a');
            $item = $link->item(0);

            $dataAttribute = 'bwrk_onepage_' . $pageId;

            $classAttribute = $dom->createAttribute('data-bwrkonepage-id');
            $classAttribute->value = $dataAttribute;
            $item->appendChild($classAttribute);

            $dom->removeChild($dom->doctype);
            $dom->replaceChild($dom->firstChild->firstChild->firstChild, $dom->firstChild);

            $newItem = $dom->saveHTML();
            return $newItem;
        }
    }
}