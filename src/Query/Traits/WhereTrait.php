<?php

namespace Pullay\Database\Query\Traits;

use Pullay\Database\Query\Predicate\Expression;

use function is_array;
use function sprintf;
use function strtoupper;

trait WhereTrait
{
     protected array $whereConditions = [];
     protected array $values = [];

    /**
     * @param Expression|string|array $condition
     */
     public function where($condition, array $parameters = []): self
     {
        if (!$condition) {
            return $this;
        }

        if ($condition instanceOf Expression) {
            $this->where($condition->getExpression(), []);
            return $this;
        }

        if (is_array($condition)) {
            foreach ($condition as $key => $value) {
                $this->where($key, $value);
            }

            return $this;
        }

        $this->addWhereConditions($condition, $parameters, 'AND');
        return $this;
     }

    /**
     * @param Expression|string|array $condition
     */
    public function andWhere($condition, array $parameters = []): self
    {
         return $this->where($condition, $parameters, 'AND');
    }

    /**
     * @param Expression|string|array $condition
     */
    public function orWhere($condition, array $parameters = []): self
    {
        if (is_array($condition)) {
            foreach ($condition as $key => $value) {
                $this->whereOR($key, $value);
            }

            return $this;
        }

        return $this->where($condition, $parameters, 'OR');
    }

    public function getWhereConditions(): array
    {
         return $this->whereConditions;
    }

    protected function addWhereConditions(string $condition, array $parameters, string $statement): void
    {
        $this->whereConditions[] = [$condition, $parameters, $statement];
    }

    protected function getClauseWhere(): string
    {
        $sql = '';

        if (!empty($this->whereConditions)) {
            $i = 0;

            foreach ($this->whereConditions as $whereCondition) {
                [$condition, $parameters, $statement] = $whereCondition;
                $this->values += $parameters;
                $clause = ($i === 0 ? 'WHERE': strtoupper($statement));
                $sql .= sprintf(" %s %s", $clause, $condition);
                $i++;
            }
        }

        return $sql;
    }
}