<?php
defined('TYPO3') or die();

// Typoscript
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bwrk_onepage',
    'Configuration/TypoScript',
    'BERGWERK Onepage [Viewer]'
);