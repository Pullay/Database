<?php

namespace Pullay\Database\Query\Predicate;

class IsNull extends BaseExpression
{
    /**
     * @var string 
     */
    protected $column;

    /**
     * @param string $column
     */
    public function __construct($column)
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
        return sprintf('%1$s IS NULL', $this->column);
    }
}
