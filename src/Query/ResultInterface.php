<?php

namespace Pullay\Database\Driver;

interface ResultInterface
{
    /**
     * @return array|null
     */
    public function fetchOne();

    /**
     * @return array
     */
    public function fetchAll();

    /**
     * @return mixed
     */
    public function fetchColumn();


    /**
     * @param string $className
     * @param array $constructorArgs
     * @return object|null|false
     */
    public function fetchObject($className, $constructorArgs = []);

    /**
     * @return int
     */
    public function numRows();
}
