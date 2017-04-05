<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$tmp_extpages_columns = array(
    'tx_bwrkonepage_sectionclass' => array(
        'exclude' => 0,
        'label' => 'Section-Class',
        'config' => array(
            'type' => 'select',
            'renderType' => 'selectSingle',
            'default' => 0,
            'items' => array(
                array('LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.sectionClassLabel', 0),
                array('Typ 1', 1),
                array('Typ 2', 2),
                array('Typ 3', 3),
                array('Typ 4', 4),
                array('Typ 5', 5),
            ),
        ),

    ),
    'tx_bwrkonepage_hidesectionmenu' => array(
        'exclude' => 0,
        'label' => 'LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.hideSectionMenuLabel',
        'config' => array(
            'type' => 'check',
            'default' => 0,
            'items' => array(
                array('LLL:EXT:bwrk_onepage/Resources/Private/Language/locallang.xlf:bwrk_onepage.pageTS.hideSectionMenuYes'),
            ),
        ),
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages',$tmp_extpages_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', '--div--;BERGWERK Onepage,tx_bwrkonepage_sectionclass,tx_bwrkonepage_hidesectionmenu', 1);

$TCA['pages_language_overlay']['interface']['showRecordFieldList'] .= ',tx_bwrkonepage_sectionclass,tx_bwrkonepage_hidesectionmenu';