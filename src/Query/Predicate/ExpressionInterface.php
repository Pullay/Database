<?php

namespace Pullay\Database\Query\Predicate;

interface ExpressionInterface
{
    public function getExpression(): string;
}
