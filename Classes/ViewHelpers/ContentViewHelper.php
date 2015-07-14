<?php
namespace BERGWERK\BwrkOnepage\ViewHelpers;

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