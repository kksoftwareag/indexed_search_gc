<?php

namespace KKSoftware\IndexedSearchGC\Task;

use KKSoftware\IndexedSearchGC\Service\GarbageCollectorService;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Class GarbageCollector
 * @package KKSoftware\IndexedSearchGC\Task
 */
class GarbageCollector extends AbstractTask
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * This is the main method that is called when a task is executed
     * It MUST be implemented by all classes inheriting from this one
     * Note that there is no error handling, errors and failures are expected
     * to be handled and logged by the client implementations.
     * Should return TRUE on successful execution, FALSE on error.
     *
     * @return bool Returns TRUE on successful execution, FALSE on error
     */
    public function execute()
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);

        /** @var ObjectManager $om */
        $om = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = $om->get(ExtensionConfiguration::class);
        $result = $extensionConfiguration->get('indexed_search_gc');

        $this->logger->debug('Configuration Data', $result);

        $service = new GarbageCollectorService($result['garbageCollectionCleanupDelay']);

        $service->collect();

        return true;
    }
}
