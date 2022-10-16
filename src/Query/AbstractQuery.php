<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;
use PDOStatement;

abstract class AbstractQuery implements Query
{
     protected Connection $connection;

     public function __construct(Connection $connection)
     {
         $this->connection = $connection;
     }

     public function execute(): PDOStatement
     {
         return $this->connection->executeQuery($this);
     }

     public function __toString(): string
     {
         return $this->getSql();
     }

     public abstract function getValues(): array;
     public abstract function getSql(): string;
}