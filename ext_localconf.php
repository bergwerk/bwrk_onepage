<?php
defined('TYPO3_MODE') or die();

$boot = function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'BERGWERK.bwrk_onepage',
        'Pi1',
        [
            'Onepage' => 'show'
        ],
        []
    );
};

$boot();
unset($boot);