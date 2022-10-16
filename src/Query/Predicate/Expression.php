<?php

namespace Pullay\Database\Query\Predicate;

interface Expression
{
    public function getExpression(): string;
}