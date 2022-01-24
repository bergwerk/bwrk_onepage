<?php
defined('TYPO3_MODE') or die();

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
                    'LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.sectionClassLabel',
                    0
                ],
                ['Typ 1', 1],
                ['Typ 2', 2],
                ['Typ 3', 3],
                ['Typ 4', 4],
                ['Typ 5', 5],
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
                ['LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.hideSectionMenuYes'],
            ],
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tmp_extpages_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--div--;BERGWERK Onepage,tx_bwrkonepage_sectionclass,tx_bwrkonepage_hidesectionmenu',
    '1'
);