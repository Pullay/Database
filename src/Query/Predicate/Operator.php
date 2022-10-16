<?php

namespace Pullay\Database\Query\Predicate;

class Operator implements Expression
{
     public const EQUAL_TO = '=';
     public const EQ  = '=';
     public const NOT_EQUAL_TO = '<>';
     public const NEQ = '<>';
     public const LEES_THAN = '<';
     public const LT  = '<';
     public const GREATER_THAN = '>';
     public const GT  = '>';
     public const LEES_THAN_OR_EQUAL_TO = '<=';
     public const LTE = '<=';
     public const GREATER_THAN_OR_EQUAL_TO = '>=';
     public const GTE = '>=';

     protected string $left;
     protected string $right;

     public function __construct(string $left, string $right, string $operator = self::EQUAL_TO)
     {
         $this->left = $left;
         $this->right = $right;
         $this->operator = $operator;
     }

     public static function equalTo(string $left, string $right): self
     {
         return new self($left, $right, self::EQUAL_TO);
     }

     public static function notEqualTo(string $left, string $right): self
     {
         return new self($left, $right, self::NOT_EQUAL_TO);
     }

     public static function lessThen(string $left, string $right): self
     {
         return new self($left, $right, self::LEES_THAN);
     }

     public static function greaterThan(string $left, string $right): self
     {
         return new self($left, $right, self::GREATER_THAN);
     }

     public static function lessThenOrEqualTo(string $left, string $right): self
     {
         return new self($left, $right, self::LEES_THAN_OR_EQUAL_TO);
     }

     public static function greaterThanOrEqualTo(string $left, string $right): self
     {
         return new self($left, $right, self::GREATER_THAN_OR_EQUAL_TO);
     }

     public function getLeft(): string
     {
         return $this->left;
     }

     public function getRight(): string
     {
         return $this->right;
     }

     public function getOperator(): string
     {
         return $this->operator;
     }

     public function getExpression(): string
     {
         return sprintf('%1$s %2$s %3$s', $this->left, $this->operator, $this->right);
     }
}