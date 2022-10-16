<?php

namespace Pullay\Database\Query\Predicate;

class IsNull implements Expression
{
     protected string $column;

     public function __construct(string $column)
     {
         $this->column = $column;
     }

     public function getColumn(): string
     {
         return $this->column;
     }

     public function getExpression(): string
     {
         return sprintf('%1$s IS NULL', $this->column);
     }
}