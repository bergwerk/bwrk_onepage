<?php

if (!defined('TYPO3_MODE'))
{
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'BERGWERK.' . $_EXTKEY,
    'Pi1',
    array(
        'Onepage' => 'show'
    ),
    array()
);