<?php

if (!defined('TYPO3_MODE'))
{
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'BERGWERK.' . $_EXTKEY,
    'onepagePlugin',
    array(
        'Onepage' => 'showOnepage'
    ),
    // non-cacheable actions
    array(
        'Onepage' => 'showOnepage'
    )
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Frontend\\ContentObject\\Menu\\TextMenuContentObject'] = array(
    'className' => 'BERGWERK\\BwrkOnepage\\Typo3Overrides\\TextMenuContentObject'
);