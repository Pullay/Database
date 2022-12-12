<?php

namespace Pullay\Database\Query;

abstract class BaseQuery implements QueryInterface
{
    protected string $tableName;

    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getValues(): array
    {
        return [];
    }

    public function getSql(): string
    {
        return '';
    }

    public function __toString()
    {
        return (string) $this->getSql();
    }
}
