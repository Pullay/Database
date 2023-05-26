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
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $tableName
     * @return Insert
     */
    public function insert($tableName)
    {
        return new Insert($this->connection, $tableName);
    }

    /**
     * @param string $tableName
     * @param array|string $columns
     * @return Select
     */
    public function select($tableName, $columns = '*')
    {
        return new Select($this->connection, $tableName, $columns);
    }

    /**
     * @param string $tableName
     * @return Update
     */
    public function update($tableName)
    {
        return new Update($this->connection, $tableName); 
    }

    /**
     * @param string $tableName
     * @return Delete
     */
    public function delete($tableName)
    {
        return new Delete($this->connection, $tableName);
    }
}
