<?php

namespace Pullay\Database\Query;

use function array_keys;
use function is_array;
use function is_string;
use function sprintf;
use function strtoupper;

class Update extends BaseQuery 
{
    use WhereTrait;
    use LimitTrait;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @param string $tableName
     * @return self
     */
    public function table($tableName)
    {
        $this->setTableName($tableName);
        return $this;
    }

    /**
     * @param array $values
     * @return self
     */
    public function sets($values)
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
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function getSql()
    {
        $columns = array_keys($this->values);
        $rowPlaceholder = [];

        foreach ($columns as $column) {
            $rowPlaceholder[] = sprintf(" %s = ?", $column);
        }

        $sql = sprintf('UPDATE %1$s SET %2$s', $this->tableName, implode(', ', $rowPlaceholder));
        $i = 0;

        foreach($this->whereConditions as $whereCondition) {
            list($statement, $condition, $params) = $whereCondition;
            $clause = ($i === 0 ? 'WHERE': strtoupper($statement));
            $sql .= sprintf(' %1$s %2$s', $clause, $condition);
            $this->values += $params;
            $i++;
        }

        if (!empty($this->numberRows)) {
            $sql .= sprintf(' LIMIT %1$s', $this->numberRows);

            if (!empty($this->offsetValue)) {
                $sql =  sprintf(' OFFSET %1$s', $this->offsetValue);
            }
        }

        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        $result = $this->connection
            ->executeQueryStatement($this);
        return $result->numRows();
    }
}