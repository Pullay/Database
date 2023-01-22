<?php

namespace Pullay\Database;

interface TransactionInterface
{
    /**
     * @return bool
     */
    public function beginTransaction();

    /**
     * @return bool
     */
    public function commit();

    /**
     * @return bool
     */
    public function rollBack();
}
