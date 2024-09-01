<?php
defined('TYPO3_MODE') or die();

// Typoscript
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bwrk_onepage',
    'Configuration/TypoScript',
    'BERGWERK Onepage [Viewer]'
);