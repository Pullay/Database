<?php

namespace Pullay\Database\Query\Predicate;

class NotLike extends Like
{
    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
        return sprintf('%1$s NOT LIKE %2$s', $this->getColumn(), $this->getPattern());
    }
}
