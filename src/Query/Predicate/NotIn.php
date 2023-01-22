<?php

namespace Pullay\Database\Query\Predicate;

class NotIn extends In
{
    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
        return sprintf('%1$s NOT IN (%2$s)', $this->column, implode(',', $this->valueSet));
    }
}
