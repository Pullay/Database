<?php

namespace Pullay\Database;

use Pullay\Database\Query\Insert;
use Pullay\Database\Query\Select;
use Pullay\Database\Query\Update;
use Pullay\Database\Query\Delete;

class QueryBuilder
{
    /**
     * @var Connection
     */
    protected $connection; 

    /**
     * @params Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * {@inheritdoc}
     */
    public function insert($tableName)
    {
        return new Insert($this->connection, $tableName);
    }

    /**
     * {@inheritdoc}
     */
    public function select($tableName, $columns = '*')
    {
        return new Select($this->connection, $tableName, $columns);
    }

    /**
     * {@inheritdoc}
     */
    public function update($tableName)
    {
        return new Update($this->connection, $tableName); 
    }

    /**
     * {@inheritdoc}
     */
    public function delete($tableName)
    {
        return new Delete($this->connection, $tableName);
    }
}
