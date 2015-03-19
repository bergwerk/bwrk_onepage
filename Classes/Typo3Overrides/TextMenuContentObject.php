<?php
namespace BERGWERK\BWrkOnepage\Typo3Overrides;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class TextMenuContentObject extends \TYPO3\CMS\Frontend\ContentObject\Menu\TextMenuContentObject
{
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