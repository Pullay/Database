<?php

namespace Pullay\Database\Query\Predicate;

class NotLike extends Like
{
     public function getExpression(): string
     {
         return sprintf('%1$s NOT LIKE %2$s', $this->getColumn(), $this->getPattern());
     }
}
