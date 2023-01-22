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
     * @return int
     */
    public function numRows();
}
