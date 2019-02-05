<?php

$EM_CONF['indexed_search_gc'] = [
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
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
            'indexed_search' => '8.7.0-8.7.99',
            'scheduler' => '8.7.0-8.7.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
