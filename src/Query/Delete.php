<?php

namespace Pullay\Database\Query;

class Delete extends AbstractQuery
{
    use Traits\WhereTrait;

    protected Connection $connection;
    protected string $tableName = '';

    public function __construct(Connection $connection, ?string $tableName = null)
    {
        parent::__construct($connection);

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
        return $this->getWhereParameters();
    }

    public function getSql(): string
    {
        $sql = sprintf('DELETE FROM %1$s', $this->tableName);
        $sql .= $this->getClauseWhere();
        return $sql;
    }
}
