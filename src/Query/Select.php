<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;
use Countable;
use IteratorAggregate;

class Select extends AbstractQuery implements Countable, IteratorAggregate
{
    use Traits\WhereTrait;
    use Traits\LimitTrait;

    public const ASC = 'ASC';
    public const DESC = 'DESC';

    protected Connection $connection;
    protected array $columns = [];
    protected string $tableName = '';
    protected array $values = [];
    protected array $group = [];
    protected ?string $sort;
    protected ?string $order;

    public function __construct(Connection $connection, ?string $tableName = null, $columns = null)
    {
        parent::__construct($connection);

        if ($columns) {
            $this->select($columns);
        }
 
        if ($tableName) {
            $this->from($tableName);
        }
    }

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
        $this->tableName = $tableName;
        return $this;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function groupBy($group): self
    {
        if (is_array($group)) {
            $this->group += $group;
        } else {
            $this->group[] = $group;
        }
        return $this;
    }

    public function getGroupBy(): array
    {
        return $this->group;
    }

    public function orderBy(string $sort, ?string $order = null): self
    {
        $this->sort = $sort;
        $this->order = $order??self::ASC;
        return $this;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function getOrderBy(): ?string
    {
        return $this->order;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getSql(): string
    {
        $columns = implode(', ', $this->columns);

        if (count($this->columns) === 0) {
            $columns = '*';
        }

        $sql = sprintf('SELECT %1$s FROM %2$s', $columns, $this->tableName);
        $sql .= $this->getClauseWhere();
        $sql .= $this->getClauseGroupBy();
        $sql .= $this->getClauseSort();
        $sql .= $this->getClauseLimit();
        $sql .= $this->getClauseOffset();
        return $sql;
    }

    public function reset(): self
    {
        $this->columns = [];
        $this->tableName = '';
        $this->group = [];
        $this->sort = null;
        $this->order = null;
        return $this;
    }

    public function fetch(): ?array
    {
        return ($row = $this->execute()->fetch()) ? $row : null;
    }

    public function fetchColumn()
    {
        return $this->execute()->fetchColumn();
    }

    public function fetchAll(): array
    {
        return $this->execute()->fetchAll();
    }

    public function count(): int
    {
        return $this->select('COUNT(*)')->fetchColumn();
    }

    public function getIterator()
    {
        return new ArrayIterator($this->fetchAll());
    }

    protected function getClauseGroupBy(): string
    {
        return (!empty($this->group) ? sprintf(' GROUP BY %1$s', implode(',', $this->group)) : '');
    }

    protected function getClauseSort(): string
    {
        return (!empty($this->sort) ? sprintf(' ORDER BY %1$s %2$s', $this->sort, $this->order) : '');
    }

    protected function getClauseOffset(): string
    {
        return (!empty($this->offset) ? sprintf(' OFFSET %1$s', $this->offset) : '');
    }
}