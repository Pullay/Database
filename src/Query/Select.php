<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;
use PDOStatement;
use Countable;
use IteratorAggregate;

use function count;
use function implode;
use function is_array;
use function is_string;
use function sprintf;

class Select implements Query, Countable, IteratorAggregate
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
        $this->connection = $connection;

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
        $columns = (count($this->columns) > 0) ? implode(', ', $this->columns) : '*';

        $sql = sprintf('SELECT %1$s FROM %2$s', $columns, $this->tableName);
        $sql .= $this->getClauseWhere();
        $sql .= $this->getClauseGroupBy();
        $sql .= $this->getClauseSort();
        $sql .= $this->getClauseLimit();
        return $sql;
    }

    public function execute(): PDOStatement
    {
        $this->values = [];
        return $this->connection->executeStatement($this);
    }

    public function fetchOne(): ?array
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

    public function __toString(): string
    {
        return $this->getSql();
    }

    protected function getClauseGroupBy(): string
    {
        return (!empty($this->group) ? sprintf(' GROUP BY %1$s', implode(',', $this->group)) : '');
    }

    protected function getClauseSort(): string
    {
        return (!empty($this->sort) ? sprintf(' ORDER BY %1$s %2$s', $this->sort, $this->order) : '');
    }
}