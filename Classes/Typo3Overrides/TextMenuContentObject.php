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

namespace BERGWERK\BwrkOnepage\Typo3Overrides;

use DOMDocument;

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

            $dom = new DOMDocument();
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