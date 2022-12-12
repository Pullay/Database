<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;
use Countable;
use IteratorAggregate;
use Pullay\Database\Query\Predicate\ExpressionInterface;
use Traversable;

use function is_array;
use function is_string;
use function strtoupper;

class Select extends BaseQuery implements Countable, IteratorAggregate
{
    use JoinTrait;
    use WhereTrait;
    use LimitTrait;

    public const ORDER_ASC     = 'ASC';
    public const ORDER_DESC    = 'DESC';

    protected bool $distinct = false;
    protected array $columns = [];
    protected array $values = [];
    protected array $groupBy = [];
    protected ?string $having = null;
    protected ?string $sort = null;
    protected ?string $order = null;

    public function __construct(Connection $connection, ?string $tableName = null, $columns = null)
    {
        $this->connection = $connection;

        if ($columns) {
            $this->select($columns);
        }
 
        if ($tableName) {
            $this->from($tableName);
        }
    }

    public function distinct(): self
    {
        $this->distinct = true;
        return $this;
    }

    public function isDistinct(): bool
    {
        return $this->distinct;
    }

    /**
     * @param string|array $columns
     */
    public function select($columns): self
    {
        if (is_string($columns)) {
            $this->columns[] = $columns;
        } elseif (is_array($columns)) {
            $this->columns = $columns;
        }

        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function from(string $tableName): self
    {
        $this->setTableName($tableName);
        return $this;
    }

    public function groupBy(array $columns): self
    {
        $this->groupBy = $columns;
        return $this;
    }

    public function getGroupBy(): array
    {
        return $this->groupBy;
    }

    /**
     * @param string|ExpressionInterface
     */
    public function having($condition): self
    {
        if (!$condition) {
            return $this;
        }

        if ($condition instanceOf ExpressionInterface) {
            $this->having = $condition->getExpression();
        }

        $this->having = $condition;
        return $this;
    }

    public function getHaving(): ?string
    {
        return $this->having;
    }

    public function orderBy(string $sort, ?string $order = null): self
    {
        $this->sort = $sort;
        $this->order = $order;
        return $this;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function getValues(): array
    {
         return $this->values;
    }

    public function getSql(): string
    {
        $columns = (count($this->columns) > 0) ? implode(', ', $this->getColumns()) : '*';
        $sql = sprintf('SELECT %1$s %2$s FROM %3$s', ($this->distinct === true) ? ' DISTINCT':'', $columns, $this->getTableName());

        if (!empty($this->getJoins())) {
            foreach ($this->getJoins() as $joins) {
                [$tableName, $condition, $type] = $joins;
                $sql .= sprintf(' %1$s JOIN %2$s ON %3$s', strtoupper($type), $tableName, $condition);
            }
        }

        if (!empty($this->getWhereConditions())) {
           $i = 0;

           foreach($this->getWhereConditions() as $whereCondition) {
               [$condition, $parameters, $statement] = $whereCondition;
               $this->values += $parameters;
               $clause = ($i === 0 ? 'WHERE': strtoupper($statement));
               $sql .= sprintf(" %s %s", $clause, $condition);
               $i++;
           }
        }

        if (!empty($this->getGroupBy())) {
            $sql .= sprintf(' GROUP BY %1$s', implode(',', $this->getGroupBy()));

            if (!empty($this->getHaving())) {
                $sql .= sprintf(' HAVING %1$s', $this->getHaving());
            }
        }

        $sql .= (!empty($this->getSort()) ? sprintf(' ORDER BY %1$s %2$s', $this->getSort(), $this->getOrder()) : '');

        if (!empty($this->getNumberRows())) {
            $sql .= sprintf(' LIMIT %1$s', $this->getNumberRows());

            if (!empty($this->getOffsetValue())) {
                $sql =  sprintf(' OFFSET %1$s', $this->getOffsetValue());
            }
        }

        return $sql;
    }

    public function fethOne(): ?array
    {
        $row = $this->connection
            ->setQueryStatement($this)
            ->execute()
            ->fetchOne();

        $this->reset();

        return $row;
    }

    public function fetchAll(): array
    {
        $rows = $this->connection
            ->setQueryStatement($this)
            ->execute()
            ->fetchOne();

        $this->reset();

        return $rows;
    }

    public function count(): int
    {
        $result = $this->select('COUNT(*)')
             ->setQueryStatement($this)
             ->execute()
             ->fetchColumn();

        $this->reset();

        return $result;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->fetchAll());
    }

    protected function reset(): void
    {
        $this->values = [];
        $this->whereConditions = [];
    }
}
