<?php

namespace Pullay\Database\Query\Predicate;

class Exits extends BaseExpression
{
     protected string $subQuery; 

     public function __construct(string $subQuery)
     {
         $this->subQuery = $subQuery;
     }

     public function getSubQuery(): string
     {
         return $this->subQuery;
     }

     public function getExpression(): string
     {
         return sprintf('EXIST %1$s', $this->subQuery);
     }
}
