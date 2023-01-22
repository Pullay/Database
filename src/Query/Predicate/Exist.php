<?php

namespace Pullay\Database\Query\Predicate;

class Exits extends BaseExpression
{
    /**
     * @var string 
     */
    protected $subQuery; 

    /**
     * @param string $subQuery
     */
    public function __construct($subQuery)
    {
        $this->subQuery = $subQuery;
    }

    /**
     * @return string
     */
    public function getSubQuery()
    {
        return $this->subQuery;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpression()
    {
        return sprintf('EXIST %1$s', $this->subQuery);
    }
}
