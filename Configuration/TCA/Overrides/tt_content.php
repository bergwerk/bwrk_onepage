<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

// Registers the plugin as its own content type (CType "bwrkonepage_pi1") and attaches
// the FlexForm directly, since list_type/subtypes plugins were removed in TYPO3 v14.
ExtensionUtility::registerPlugin(
    'BwrkOnepage',
    'Pi1',
    'BERGWERK Onepage Viewer',
    null,
    'plugins',
    '',
    'FILE:EXT:bwrk_onepage/Configuration/FlexForms/Show.xml'
);