<?php

namespace Pullay\Database\Driver;

use PDOStatement;

class PdoResult implements ResultInterface
{
    /**
     * @var PDOStatement|null
     */
    protected $result;

    /**
     * @param PDOStatement|bool
     */
    public function __construct($result)
    {
        $this->result = is_bool($result) ? null : $result;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchOne()
    {
        if (! $this->result) {
            return null;
        }

        $row = $this->result->fetch();
        return $row === false ? null : $row;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll()
    {
        if (! $this->result) {
            return [];
        }

        $rows = $this->result->fetchAll();
        return $rows;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn()
    {
        if (! $this->result) {
            return false;
        }

        return $this->result->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function fetchObject($className, $constructorArgs = [])
    {
        if (! $this->result) {
            return false;
        }

        $row = $this->result->fetchObject($className, $constructorArgs);
        return $row === false ? null : $row;
    }

    /**
     * {@inheritdoc}
     */
    public function numRows()
    {
        if (! $this->result) {
            return 0;
        }

        return $this->result->rowCount();
    }
}
