<?php

namespace Pullay\Database\Query;

use Pullay\Database\Driver\ResultInterface;
use Countable;
use IteratorAggregate;
use Pullay\Database\Connection;
use ArrayIterator;
use Traversable;

use function is_array;
use function is_string;
use function sprintf;
use function strtoupper;

class Select extends BaseQuery implements ResultInterface, Countable, IteratorAggregate
{
    use JoinTrait;
    use WhereTrait;
    use LimitTrait;

    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

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
     * @var array
     */
    protected $orderBy = [];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * {@inheritdoc}
     * @param array|string $columns
     */
    public function __construct(Connection $connection, $tableName, $columns = '*')
    {
        $this->select($columns);
        parent::__construct($connection, $tableName);
    }

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
     * @param string $expression
     * @param string $order
     * @return self
     */
    public function orderBy($expression, $sort = self::SORT_ASC): self
    {
        $this->orderBy = [$expression, $sort];
        return $this;
    }

    /**
     * @param string $expression
     * @return self
     */
    public function orderByAsc($expression)
    {
        return $this->orderBy($expression, 'ASC');
    }

    /**
     * @param string $expression
     * @return self
     */
    public function orderByDesc($expression)
    {
        return $this->orderBy($expression, 'DESC');
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
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
        $distinct = ($this->isDistinct === true ? 'DISTINCT' : '');
        $sql = "SELECT $distinct $columns FROM $this->tableName";

        foreach ($this->join as $join) {
            list($type, $table, $on) = $join;
            $sql .= sprintf(' %1$s JOIN %2$s ON %3$s', strtoupper($type), $table, $on);
        }

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

        if (!empty($this->orderBy)) {
            list($expression, $sort) = $this->orderBy;
            $sql .= sprintf(' ORDER BY %1$s %2$s', strtoupper($expression), $sort);
        }

        if (!empty($this->numberRows)) {
            $sql .= " LIMIT $this->numberRows";

            if (!empty($this->offsetValue)) {
                $sql .=  " OFFSET $this->offsetValue";
            }
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchOne()
    {
        return $this->getResult()->fetchOne();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll()
    {
        return $this->getResult()->fetchAll();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn()
    {
        return $this->getResult()->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchObject($className, $constructorArgs = [])
    {
        return $this->getResult()->fetchObject($className, $constructorArgs = []);
    }

    /**
     * {@inheritdoc}
     */
    public function numRows()
    {
        return $this->getResult()->numRows();
    }

    /**
     * @param string $column
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        $sql = clone $this;
        return $sql->select('COUNT(*)')->numRows();
    }

    /**
     * @return Traversable
     */
     #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return ArrayIterator($this->fetchAll());
    }

    /**
     * return ResultInterface
     */
    private function getResult()
    {
        return $this->connection
            ->executeQueryStatement($this);
    }
}
