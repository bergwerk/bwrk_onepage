<?php
defined('TYPO3_MODE') or die();

$boot = function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'BwrkOnepage',
        'Pi1',
        [
            \BERGWERK\BwrkOnepage\Controller\OnepageController::class => 'show'
        ],
        []
    );
};

$boot();
unset($boot);