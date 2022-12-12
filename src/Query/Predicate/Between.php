<?php

namespace Pullay\Database\Query\Predicate;

class Between extends BaseExpression
{
     protected string $column;
     protected int $minValue;
     protected int $maxValue;

     public function __construct(string $column, int $minValue, int $maxValue)
     {
         $this->column   = $column;
         $this->minValue = $start;
         $this->maxValue = $end;
     }

     public function getColumn(): string
     {
         return $this->column;
     }

     public function getMinValue(): int
     {
         return $this->minValue;
     }

     public function getMaxValue(): int
     {
         return $this->maxValue;
     }

     public function getExpression(): string
     {
         return sprintf('%1$s BETWEEN %2$s AND %3$s', $this->column, $this->minValue, $this->maxValue);
     }
}
