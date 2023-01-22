<?php

namespace Pullay\Database;

use Pullay\Database\Driver\DriverInterface;
use Pullay\Database\Driver\ResultInterface;
use Pullay\Database\Query\QueryInterface;

class Connection
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return ResultInterface
     */
    public function rawQuery($sql, $params = [])
    {
        return $this->driver->prepareQuery($sql, $params);
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return new QueryBuilder($this);
    }

    /**
     * @param Query $query
     * @return ResultInterface
     */
    public function executeQueryStatement(QueryInterface $query)
    {
        return $this->driver->prepareQuery($query->getSql(), $query->getValues());
    }
}
