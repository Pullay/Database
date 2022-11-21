<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;

use function sprintf;

class Delete implements Query
{
    use Traits\WhereTrait;

    protected Connection $connection;
    protected string $tableName = '';
    protected array $values = [];

    public function __construct(Connection $connection, ?string $tableName = null)
    {
        $this->connection = $connection;

        if ($tableName) {
            $this->from($tableName);
        }
    }

    public function from(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getSql(): string
    {
        $sql = sprintf('DELETE FROM %1$s', $this->tableName);
        $sql .= $this->getClauseWhere();
        return $sql;
    }

    public function execute(): void
    {
        $this->connection->executeStatement($this);
        $this->values = [];
    }

    public function __toString(): string
    {
        return $this->getSql();
    }
}
