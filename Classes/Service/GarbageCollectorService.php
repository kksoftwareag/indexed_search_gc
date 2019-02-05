<?php

namespace KKSoftware\IndexedSearchGC\Service;


use Doctrine\DBAL\Driver\Statement;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class GarbageCollectorService
 * @package KKSoftware\IndexedSearchGC\Service
 */
class GarbageCollectorService
{
    /**
     * @var Logger $logger
     */
    protected $logger;
    /**
     * @var int $cleanupDelay
     */
    protected $cleanupDelay;
    /**
     * @var ConnectionPool $connectionPool
     */
    protected $connectionPool;
    /**
     * @var Connection $connection
     */
    protected $connection;

    /**
     * @var Statement[] $statements
     */
    protected $statements = [];

    /**
     *
     */
    protected const TABLE_INDEX = 'index_phash';

    /**
     * GarbageCollectorService constructor.
     * @param $cleanupDelay
     */
    public function __construct(int $cleanupDelay = 48)
    {
        $this->cleanupDelay = $cleanupDelay;
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }

    /**
     *
     */
    public function collect()
    {
        $this->logger->debug('Garbage Collection Started');

        $this->connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $this->connection = $this->connectionPool->getConnectionForTable($this::TABLE_INDEX);

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();

        $statement = $queryBuilder->select('phash')
            ->from($this::TABLE_INDEX)
            ->where(
                $queryBuilder->expr()->lt('tstamp', time() - (3600 * $this->cleanupDelay))
            );

        $this->logger->debug('Get Entries', [$statement->getSQL()]);

        $result = $statement->execute();

        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);

        $this->prepareStatements();

        foreach ($rows as $row) {
            $this->deleteData($row['phash']);
        }
    }

    /**
     *
     */
    protected function prepareStatements()
    {
        $this->statements[] = $this->connection->prepare('DELETE FROM index_fulltext WHERE phash = ?');
        $this->statements[] = $this->connection->prepare('DELETE FROM index_section WHERE phash = ?');
        $this->statements[] = $this->connection->prepare('DELETE FROM index_rel WHERE phash = ?');
        $this->statements[] = $this->connection->prepare('DELETE FROM index_grlist WHERE phash = ?');
        $this->statements[] = $this->connection->prepare('DELETE FROM index_phash WHERE phash = ?');
    }

    /**
     * @param int $phash
     */
    protected function deleteData(int $phash)
    {
        $counter = 0;

        $this->logger->debug('Delete Data for phash', [$phash]);

        foreach ($this->statements as $statement) {
            $statement->bindValue(1, $phash);
            $statement->execute();

            $counter += $statement->rowCount();
        }

        $this->logger->info('Deleted Rows', [$counter]);
    }
}