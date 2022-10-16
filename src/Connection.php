<?php

namespace Pullay\Database;

use PDO;
use Psr\Log\LoggerInterface;
use PDOStatement;
use Pullay\Database\Query\Query;
use Throwable;

use function array_fill;
use function array_keys;
use function array_values;
use function count;
use function implode;
use function sprintf;

class Connection
{
    protected Pdo $pdo;
    protected ?LoggerInterface $logger;

    public function __construct(PDO $pdo, ?LoggerInterface $logger = null)
    {
        $this->pdo = $pdo;
        $this->logger = $logger;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getServerVersion(): string
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function getClientVersion(): string 
    {
        return $this->pdo->getAttribute(PDO::ATTR_CLIENT_VERSION);
    }

    public function getDriverName(): string
    {
        return $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this);
    }

    public function batchInsert(string $tableName, array $values): void
    {
        $rowPlaceholder = array_fill(0, count($values), '?');
        $rawQuery = sprintf('INSERT INTO %1$s (%2$s) VALUES (%3$s)', $tableName, implode(', ', array_keys($values)), implode(', ', $rowPlaceholder));
        $this->executeSql($rawQuery, array_values($values));
    }

    public function executeSql(string $sql, array $values = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt;
    }

    public function executeStatement(Query $query): PDOStatement
    {
         return $this->executeSql($query->getSql(), $query->getValues());
    }

    /**
     * @return int|false
     */
    public function lastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }

    public function transaction(callable $callback)
    {
         $this->beginTransaction();

         try {
             $result = $callback($this);
             $this->commit();
         } catch (Throwable $e) {
             $this->rollback();
             throw $e;
         }
         
         return $result;
    }
}