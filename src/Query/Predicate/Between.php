<?php

namespace Pullay\Database\Query\Predicate;

class Between implements Expression
{
     protected string $column;
     protected int $start;
     protected int $end;

     public function __construct(string $column, int $start, int $end)
     {
         $this->column = $column;
         $this->start = $start;
         $this->end = $end;
     }

     public function getColumn(): string
     {
         return $this->column;
     }

     public function getStart(): int
     {
         return $this->start;
     }

     public function getEnd(): int
     {
         return $this->end;
     }

     public function getExpression(): string
     {
         return sprintf('%1$s BETWEEN %2$s AND %3$s', $this->column, $this->start, $this->end);
     }
}