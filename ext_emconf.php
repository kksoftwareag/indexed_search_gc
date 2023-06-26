<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Indexed Search Garbage Collector',
    'description' => 'Provides a configurable Scheduler Task to Cleanup old IndexedSearch Entries',
    'category' => 'plugin',
    'author' => 'K&K Software AG',
    'author_email' => 'sirlinger@kk-software.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-11.5.99',
            'indexed_search' => '9.5.0-11.5.99',
            'scheduler' => '9.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
