<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;

use function array_fill;
use function array_keys;
use function array_values;
use function count;
use function implode;
use function sprintf;

class Insert implements Query
{
    protected Connection $connection;
    protected string $tableName = '';
    protected array $values = [];

    public function __construct(Connection $connection, ?string $tableName = null)
    {
        $this->connection = $connection;

        if ($tableName) {
            $this->into($tableName);
        }
    }

    public function into(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function values(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    public function getValues(): array
    {
        return array_values($this->values);
    }

    public function getSql(): string
    {
        $rowPlaceholder = array_fill(0, count($this->values), '?');
        $sql = sprintf('INSERT INTO %1$s (%2$s) VALUES (%3$s)', $this->tableName, implode(', ', array_keys($this->values)), implode(', ', $rowPlaceholder));
        return $sql;
    }

    public function execute(): PDOStatement
    {
        $this->values = [];
        return $this->connection->executeStatement($this);
    }

    public function __toString(): string
    {
        return $this->getSql();
    }
}