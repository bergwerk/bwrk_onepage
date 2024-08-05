<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$tmp_extpages_columns = [
    'tx_bwrkonepage_sectionclass' => [
        'exclude' => 0,
        'label' => 'Section-Class',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'default' => 0,
            'items' => [
                [
                    'label' => 'LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.sectionClassLabel',
                    'value' => 0
                ],
                ['label' => 'Typ 1', 'value' => 1],
                ['label' => 'Typ 2', 'value' => 2],
                ['label' => 'Typ 3', 'value' => 3],
                ['label' => 'Typ 4', 'value' => 4],
                ['label' => 'Typ 5', 'value' => 5],
            ],
        ],

    ],
    'tx_bwrkonepage_hidesectionmenu' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.hideSectionMenuLabel',
        'config' => [
            'type' => 'check',
            'default' => 0,
            'items' => [
                ['label' => 'LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.hideSectionMenuYes'],
            ],
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('pages', $tmp_extpages_columns);
ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;BERGWERK Onepage,tx_bwrkonepage_sectionclass,tx_bwrkonepage_hidesectionmenu',
    '1'
);