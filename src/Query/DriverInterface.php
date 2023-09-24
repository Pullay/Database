<?php

namespace Pullay\Database\Driver;

use Pullay\Database\TransactionInterface;

interface DriverInterface extends TransactionInterface
{
    /**
     * @return int
     */
    public function getServerVersion();

    /**
     * @return int
     */
    public function getClientVersion();

    /**
     * @return array
     */
    public function getServerInfo();

    /**
     * @return string
     */
    public function getDrivername();

    /**
     * @param string $sql
     * @param array $params
     * @return ResultInterface
     */
    public function prepareQuery($sql, $params = []);

    /**
     * @return int
     */
    public function lastInsertId();
}

