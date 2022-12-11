<?php

namespace Pullay\Database\Query\Predicate;

class BaseExpression implements ExpressionInterface
{
    public function getExpression(): string
    {
        return '';
    }

    public function __toString(): string
    {
        return (string) $this->getExpression();
    }
}
