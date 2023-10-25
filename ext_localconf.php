<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}

/*
* Configuration for Scheduler TASK
*/
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\KKSoftware\IndexedSearchGC\Task\GarbageCollector::class] = [
    'extension' => 'indexed_search_gc',
    'title' => 'Indexed Search Garbage Collection',
    'description' => '',
    'additionalFields' => ''
];
