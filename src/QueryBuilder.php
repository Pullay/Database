<?php

namespace Pullay\Database;

use Pullay\Database\Query\Insert;
use Pullay\Database\Query\Select;
use Pullay\Database\Query\Update;
use Pullay\Database\Query\Delete;

class QueryBuilder
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
         $this->connection = $connection;
    }

    public function getConnection(): Connection
    {
         return $this->connection;
    }

    public function insert(?string $tableName = null): Insert
    {
        return new Insert($this->connection, $tableName);
    }

    /**
     * @param array|string $columns
     */
    public function select(?string $tableName = null, $columns = '*'): Select
    {
        return new Select($this->connection, $tableName, $columns);
    }

    public function update(?string $tableName = null): Update
    {
        return new Update($this->connection, $tableName);
    }

    public function delete(?string $tableName = null): Delete
    {
        return new Delete($this->connection, $tableName);
    }
}
