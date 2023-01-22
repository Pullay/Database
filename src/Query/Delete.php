<?php

namespace Pullay\Database\Query;

use function sprintf;
use function strtoupper;

class Delete extends BaseQuery 
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
    public function from($tableName)
    {
        $this->setTableName($tableName);
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
        $sql = sprintf('DELETE FROM %1$s', $this->tableName);
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