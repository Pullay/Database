<?php

namespace Pullay\Database\Query;

trait JoinTrait
{
    /**
     * @var array
     */
    protected $join = [];

    /**
     * @param string $table
     * @param string $on
     * @param string $statement
     * @return self
     */
    public function join($table, $on, $statement = 'INNER')
    {
        $this->join[] = [$statement, $table, $on];
        return $this;
    }

    /**
     * @param string $table
     * @param string $on
     * @return self
     */
    public function innerJoin($table, $on)
    {
        return $this->join($table, $on, 'INNER');
    }

    /**
     * @param string $table
     * @param string $on
     * @return self
     */
    public function leftJoin($table, $on)
    {
        return $this->join($table, $on, 'LEFT');
    }

    /**
     * @param string $table
     * @param string $on
     * @return self
     */
    public function rightJoin($table, $on)
    {
        return $this->join($table, $on, 'RIGHT');
    }

    /**
     * @return array
     */
    public function getJoin()
    {
        return $this->join;
    }
}
