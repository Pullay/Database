<?php

namespace Pullay\Database\Query\Predicate;

interface ExpressionInterface
{
    /**
     * @return string
     */
    public function getExpression();
}
