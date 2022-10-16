<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;

class Insert extends AbstractQuery
{
    protected Connection $connection;
    protected string $tableName = '';
    protected array $values;

    public function __construct(Connection $connection, ?string $tableName = null)
    {
        parent::__construct($connection);

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
        $values = array_fill(0, count($this->getValues()), '?');
        $sql = sprintf('INSERT INTO %1$s (%2$s) VALUES (%3$s)', $this->tableName, implode(', ', array_keys($this->values)), implode(', ', $values));
        return $sql;
    }
}