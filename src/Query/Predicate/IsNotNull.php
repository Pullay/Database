<?php

namespace Pullay\Database\Query\Predicate;

class IsNotNull extends IsNull
{
     public function getExpression(): string
     {
         return sprintf('%1$s IS NOT NULL', $this->getColumn());
     }
}
