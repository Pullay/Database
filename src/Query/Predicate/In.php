<?php

namespace Pullay\Database\Query\Predicate;

class In implements Expression
{
     protected string $column;
     protected array $sets;

     public function __construct(string $column, array $sets)
     {
         $this->column = $column;
         $this->sets = $sets;
     }

     public function getExpression(): string
     {
         return sprintf('%1$s IN (%2$s)', $this->column, implode(',', $this->sets));
     }
}