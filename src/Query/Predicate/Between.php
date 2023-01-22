<?php

namespace Pullay\Database\Query\Predicate;

class Between extends BaseExpression
{
    /**
     * @var string 
     */
    protected $column = '';

    /**
     * @var string|int
     */
    protected $minValue = '';

    /**
     * @var string|int
     */
    protected $maxValue = '';

    /**
     * @param string $column
     * @param string|int $minValue
     * @param string|int $maxValue
     */
    public function __construct($column, $minValue, $maxValue)
    {
        $this->column   = $column;
        $this->minValue = $start;
        $this->maxValue = $end;
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @return string|int
     */
    public function getMinValue()
    {
        return $this->minValue;
    }

    /**
     * @return string|int
     */
    public function getMaxValue()
    {
        return $this->maxValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
         return sprintf('%1$s BETWEEN %2$s AND %3$s', $this->column, $this->minValue, $this->maxValue);
    }
}
