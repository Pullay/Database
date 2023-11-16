<?php

namespace Pullay\Database\Driver;

use PDOStatement;
use ArrayIterator;
use Traversable;

class PdoResult implements ResultInterface
{
    /**
     * @var PDOStatement
     */
    protected $result;


    public function __construct(PDOStatement $result)
    {
        $this->result = $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchOne()
    {
        $row = $this->result->fetch();
        return $row === false ? null : $row;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll()
    {
        $rows = $this->result->fetchAll();
        return $rows;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn()
    {
        return $this->result->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchObject($className, $constructorArgs = [])
    {
        $row = $this->result->fetchObject($className, $constructorArgs);
        return $row === false ? null : $row;
    }

    /**
     * {@inheritdoc}
     */
    public function numRows()
    {
        return $this->rowCount();
    }

    /**
     * {@inheritdoc}
     */
    public function rowCount()
    {
        return $this->result->rowCount();
    }

    /**
     * @return Traversable
     */
     #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return ArrayIterator($this->fetchAll());
    }
}
