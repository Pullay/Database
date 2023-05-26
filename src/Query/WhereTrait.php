<?php

namespace Pullay\Database\Query;

use Pullay\Database\Query\Predicate\ExpressionInterface;

use function is_array;

trait WhereTrait
{
    /**
     * @param array
     */
    protected $whereConditions = [];

    /**
     * @param string|array|ExpressionInterface $condition
     * @param array $parameters
     * @param string $statement
     * @return self
     */
     public function where($condition, $parameters = [], $statement = 'AND')
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

        $this->whereConditions[] = [$statement, $condition, $parameters];
        return $this;
     }

    /**
     * @param string|array|ExpressionInterface $condition
     * @param array $parameters
     * @return self
     */
    public function andWhere($condition, $parameters = [])
    {
         return $this->where($condition, $parameters);
    }

    /**
     * @param string|array|ExpressionInterface $condition
     * @param array $parameters
     * @return self
     */
    public function orWhere($condition, $parameters = [])
    {
        return $this->where($condition, $parameters, 'OR');
    }

    /**
     * @return array
     */
    public function getWhereConditions()
    {
         return $this->whereConditions;
    }
}
