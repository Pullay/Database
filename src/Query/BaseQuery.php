<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;

use function is_string;

abstract class BaseQuery implements QueryInterface
{
    /**
     * @var Connection
     */
    protected $connection; 

    /**
     * @var string
     */
    protected $tableName = null;

    /**
     * @param Connection $connection
     * @param string $tableName
     */
    public function __construct(Connection $connection, $tableName)
    {
        $this->connection = $connection;
        $this->setTableName($tableName);
    }

    /**
     * @param Connection $connection
     * @return self
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @param string $tableName
     * @return self
     */
    public function setTableName($tableName)
    {
        if (is_string($tableName)) {
            $this->tableName = $tableName;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTableName()
    {
        return $tableName;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getSql()
    {
        return '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getSql();
    }
}
