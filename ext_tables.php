<?php

if (!defined('TYPO3_MODE'))
{
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'BERGWERK.'.$_EXTKEY,
    'Pi1',
    'BERGWERK Onepage Viewer'
);

// Typoscript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Defaults', 'BERGWERK Onepage [Defaults (optional)]');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'BERGWERK Onepage [Viewer]');


// Flexform einbinden
$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName = strtolower('Pi1');
$pluginSignature = $extensionName . '_' . $pluginName;
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Show.xml');





// Add tx_bwrkonepage_sectionclass to pages

$tmp_extpages_columns = array(
    'tx_bwrkonepage_sectionclass' => array(
        'exclude' => 0,
        'label' => 'Section-Class',
        'config' => array(
            'type' => 'select',
            'default' => 0,
            'items' => array(
                array('-- Bitte wählen --', 0),
                array('Typ 1', 1),
                array('Typ 2', 2),
                array('Typ 3', 3),
                array('Typ 4', 4),
                array('Typ 5', 5),
            ),
        ),

    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages',$tmp_extpages_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages_language_overlay',$tmp_extpages_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', '--div--;BERGWERK Onepage,tx_bwrkonepage_sectionclass', 1);
$TCA['pages_language_overlay']['interface']['showRecordFieldList'] .= ',tx_bwrkonepage_sectionclass';