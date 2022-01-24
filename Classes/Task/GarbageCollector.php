<?php

namespace KKSoftware\IndexedSearchGC\Task;

use KKSoftware\IndexedSearchGC\Service\GarbageCollectorService;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Class GarbageCollector
 * @package KKSoftware\IndexedSearchGC\Task
 */
class GarbageCollector extends AbstractTask
{
    /**
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     *
     * @return bool Returns TRUE on successful execution, FALSE on error
     */
    public function execute(): bool
    {
        $cleanupDelay = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('indexed_search_gc', 'garbageCollectionCleanupDelay');

        $service = new GarbageCollectorService($cleanupDelay);

        $service->collect();

        return true;
    }
}
