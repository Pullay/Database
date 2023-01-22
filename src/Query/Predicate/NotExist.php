<?php

namespace Pullay\Database\Query\Predicate;

class NotExist extends Exits
{
    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
        return sprintf('NOT EXIST %1$s', $this->subQuery);
    }
}
