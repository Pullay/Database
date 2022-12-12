<?php

namespace Pullay\Database;

use Pullay\Database\Driver\DriverInterface;
use Pullay\Database\Query\QueryInterface;

use function array_fill;
use function array_keys;
use function array_values;

class Connection
{
    protected DriverInterface $driver;
    protected QueryInterface $queryStatement;

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    public function batchInsert(string $tableName, array $values): ?int
    {
        $rowPlaceholder = array_fill(0, count($values), '?');
        $rawQuery = sprintf('INSERT INTO %1$s (%2$s) VALUES (%3$s)', $tableName, implode(', ', array_keys($values)), implode(', ', $rowPlaceholder));
        $this->driver->prepareQuery($rawQuery, array_values($values));
        $insertId = $this->driver->lastInsertedId();
        return ($insertId !== false) ? $insertId : null;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this);
    }

    public function setQueryStatement(QueryInterface $queryStatement): self
    {
        $this->queryStatement = $queryStatement;
        return $this;
    }

    public function execute(): DriverInterface
    {
        if ($this->queryStatement) {
            $driver = $this->driver->prepareQuery($this->queryStatement->getSql(), $this->queryStatement->getValues());
            return $driver;
        }
    }
}
