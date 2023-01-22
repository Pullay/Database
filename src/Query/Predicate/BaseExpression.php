<?php

namespace Pullay\Database\Query\Predicate;

class BaseExpression implements ExpressionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
        return '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getExpression();
    }
}
