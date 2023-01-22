<?php

namespace Pullay\Database\Query;

use Countable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

use function is_array;
use function is_string;
use function sprintf;
use function strtoupper;

class Select extends BaseQuery implements Countable, IteratorAggregate
{
    use WhereTrait;
    use LimitTrait;

    /**
     * @var bool
     */
    protected $isDistinct = false;

    /**
     * @var array
     */
    protected $columns = ['*'];

    /**
     * @var array
     */
    protected $groupBy = [];

    /**
     * @var string|null
     */
    protected $order = null;

    /**
     * @var string|null
     */
    protected $sort = null;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @return self
     */
    public function distinct()
    {
        $this->isDistinct = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDistinct()
    {
        return $this->distinct;
    }

    /**
     * @param string|array $column
     * @return self
     */
    public function select($columns)
    {
        if (is_string($columns)) {
            $this->columns[0] = $columns;
        } elseif (is_array($columns)) {
            $this->columns = $columns;
        }

        return $this;
    }

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
     * @param array
     * @return self
     */
    public function groupBy($columns)
    {
        if (is_array($columns)) {
            $this->groupBy = $columns;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * @param string $sort
     * @param string $order
     * @return self
     */
    public function orderBy($sort, $order = null): self
    {
        $this->sort = $sort;
        $this->order = $order;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return string|null
     */
    public function getOrder()
    {
        return $this->order;
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
        $columns = (count($this->columns) > 0) ? implode(', ', $this->columns) : '*';
        $sql = sprintf('SELECT %1$s %2$s FROM %3$s', ($this->isDistinct === true ? 'DISTINCT' : ''), $columns, $this->tableName);
        $i = 0;

        foreach($this->whereConditions as $whereCondition) {
            list($statement, $condition, $params) = $whereCondition;
            $clause = ($i === 0 ? 'WHERE': strtoupper($statement));
            $sql .= sprintf(' %1$s %2$s', $clause, $condition);
            $this->values += $params;
            $i++;
        }

        if (!empty($this->groupBy)) {
            $sql .= sprintf(' GROUP BY %1$s', implode(',', $this->groupBy));
        }

        $sql .= (!empty($this->sort) ? sprintf(' ORDER BY %1$s %2$s', $this->sort, $this->order) : '');

        if (!empty($this->numberRows)) {
            $sql .= sprintf(' LIMIT %1$s', $this->numberRows);

            if (!empty($this->offsetValue)) {
                $sql =  sprintf(' OFFSET %1$s', $this->offsetValue);
            }
        }

        return $sql;
    }

    /**
     * @return array|null
     */
    public function fetchOne()
    {
        return $this->connection
            ->executeQueryStatement($this)
            ->fetchOne();
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->connection
            ->executeQueryStatement($this)
            ->fetchAll();
    }

    /**
     * @return int
     */
    public function count()
    {
        $sql = clone $this;
        return $sql->select('COUNT(*)')->numRows();
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return ArrayIterator($this->fetchAll());
    }

    /**
     * @return int
     */
    protected function numRows()
    {
        return $this->connection
            ->executeQueryStatement($this)
            ->numRows();
    }
}
