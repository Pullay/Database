<?php

namespace Pullay\Database\Query;

use Pullay\Database\Query\Predicate\ExpressionInterface;

use function is_array;

trait WhereTrait
{
    protected array $whereConditions = [];

    /**
     * @param string|array|ExpressionInterface $condition
     */
     public function where($condition, array $parameters = []): self
     {
        if (!$condition) {
            return $this;
        }

        if ($condition instanceOf ExpressionInterface) {
             $this->where($condition->getExpression(), $parameters);
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
     * @param string|array|ExpressionInterface $condition
     */
    public function andWhere($condition, array $parameters = []): self
    {
         return $this->where($condition, $parameters, 'AND');
    }

    /**
     * @param string|array|ExpressionInterface $condition
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
}
