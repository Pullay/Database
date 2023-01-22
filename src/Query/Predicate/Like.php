<?php

namespace Pullay\Database\Query\Predicate;

class Like extends BaseExpression
{
    /**
     * @var string 
     */
    protected $field = '';

    /**
     * @var string 
     */
    protected $pattern = '';

    /**
     * @param string $column
     * @param string $pattern
     */
    public function __construct($column, $pattern)
    {
        $this->column = $column;
        $this->pattern = $pattern;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
         return sprintf('%1$s LIKE %2$s', $this->column, $this->pattern);
    }
}
