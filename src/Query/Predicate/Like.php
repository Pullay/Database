<?php

namespace Pullay\Database\Query\Predicate;

class Like implements Expression
{
     protected string $column;
     protected string $pattern;

     public function __construct(string $column, string $pattern)
     {
         $this->column = $column;
         $this->pattern = $pattern;
     }

     public function getColumn(): string
     {
         return $this->column;
     }

     public function getPattern(): string 
     {
         return $this->pattern;
     }

     public function getExpression(): string
     {
         return sprintf('%1$s LIKE %2$s', $this->column, $this->pattern);
     }
}