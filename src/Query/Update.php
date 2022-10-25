<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;

use function array_keys;
use function implode;
use function sprintf;

class Update implements Query
{
    use Traits\WhereTrait;
    use Traits\LimitTrait;

    protected Connection $connection;
    protected string $tableName = '';
    protected array $values = [];

    public function __construct(Connection $connection, ?string $tableName = null)
    {
        $this->connection = $connection;

        if ($tableName) {
            $this->table($tableName);
        }
    }

    public function table(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function set(array $values): self
    {
        $this->values += $values;
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getSql(): string
    {
        $columns = array_keys($this->values);
        $rowPlaceholder = [];

        foreach ($columns as $column) {
            $rowPlaceholder[] = sprintf(" %s = :%s", $column, $column);
        }

        $sql = sprintf('UPDATE %1$s SET %2$s', $this->tableName, implode(', ', $rowPlaceholder));
        $sql .= $this->getClauseWhere();
        $sql .= $this->getClauseLimit();
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