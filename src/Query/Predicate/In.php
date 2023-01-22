<?php

namespace Pullay\Database\Query\Predicate;

class In extends BaseExpression
{
    /**
     * @var string 
     */
    protected $column = '';

    /**
     * @var string 
     */
    protected $valueSet = [];

    /**
     * @param string $column
     * @param array $valueSet
     */
    public function __construct($column, $valueSet)
    {
        $this->column = $column;
        $this->valueSet = $valueSet;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @return array
     */
    public function getValueSet()
    {
        return $this->valueSet;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
        return sprintf('%1$s IN (%2$s)', $this->column, implode(',', $this->valueSet));
    }
}
