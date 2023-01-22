<?php

namespace Pullay\Database\Query;

use function array_fill;
use function array_keys;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

class Insert extends BaseQuery
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @param string $tableName
     * @return self
     */
    public function into($tableName)
    {
        $this->setTableName($tableName);
        return $this;
    }

    /**
     * @param array $values
     * @return self
     */
    public function values($values)
    {
        if (is_array($values)) {
            $this->values += $values;
        }
        return $this;
    }

    /**
     * @param string $column
     * @param mixed $value
     * @return self
     */
    public function set($column, $value)
    {
        if (is_string($column)) {
           $this->values[$column] = $value;
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return array_values($this->values);
    }

    /**
     * {@inheritdoc}
     */
    public function getSql()
    {
        $rowPlaceholder = array_fill(0, count($this->values), '?');
        $sql = sprintf('INSERT INTO %1$s (%2$s) VALUES (%3$s)', $this->tableName, implode(', ', array_keys($this->values)), implode(', ', $rowPlaceholder));
        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        $this->connection
           ->executeQueryStatement($this);
        return $this->connection
           ->getDriver()
           ->lastInsertId();
    }
}
