<?php

namespace Pullay\Database;

use Pullay\Database\Driver\DriverInterface;
use Pullay\Database\Query\QueryInterface;

use function array_fill;
use function array_keys;
use function array_values;
use function sprintf;

class Connection
{
    protected DriverInterface $driver;
    protected ?QueryInterface $queryStatement;

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    /**
     * @return false|int
     */
    public function batchInsert(string $tableName, array $values)
    {
        $rowPlaceholder = array_fill(0, count($values), '?');
        $rawQuery = sprintf('INSERT INTO %1$s (%2$s) VALUES (%3$s)', $tableName, implode(', ', array_keys($values)), implode(', ', $rowPlaceholder));
        $result = $this->driver->prepareQuery($rawQuery, array_values($values));
        return $result->lastInsertedId();;
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

    public function getQueryStatement(): ?QueryInterface
    {
        return $this->queryStatement;
    }

    /**
     * @return DriverInterface|false
     */
    public function execute()
    {
        if ($this->queryStatement) {
            return $this->driver->prepareQuery($this->queryStatement->getSql(), $this->queryStatement->getValues());
        }

        return false;
    }
}
