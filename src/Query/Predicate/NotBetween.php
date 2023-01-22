<?php

namespace Pullay\Database\Query\Predicate;

class NotBetween extends Between
{
    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
         return sprintf('%1$s NOT BETWEEN %2$s AND %3$s', $this->column, $this->minValue, $this->maxValue);
    }
}
