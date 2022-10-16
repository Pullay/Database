<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;

class Update extends AbstractQuery
{
    use Traits\WhereTrait;
    use Traits\LimitTrait;

    protected Connection $connection;
    protected string $tableName = '';
    protected array $values = [];

    public function __construct(Connection $connection, ?string $tableName = null)
    {
        parent::__construct($connection);

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
        $columnsQuery = [];

        foreach ($columns as $column) {
            $columnsQuery[] = sprintf(" %s = :%s", $column, $column);
        }

        $sql = sprintf('UPDATE %1$s SET %2$s', $this->tableName, implode(', ', $columnsQuery));
        $sql .= $this->getClauseWhere();
        $sql .= $this->getClauseLimit();
        return $sql;
    }
}
