<?php

namespace Pullay\Database\Query\Predicate;

class CompositeExpression implements Expression
{
    protected string $operator = 'and';

    /**
     * @var Expression[]
     */
    protected array $expressions = [];

    /**
     * @param Expression[] $expressions
     */
    public function __construct(string $operator, array $expressions)
    {
        $this->operator = $operator;
        $this->expressions = $expressions;
    }

    public static function And(...$expression): self
    {
        return new self('AND', $expression);
    }

    public static function OR(...$expression): self
    {
        return new self('OR', $expression);
    }

    public function getExpression(): string
    {
        return implode(' '.strtoupper($this->operator).' ', $this->expressions);
    }
}
