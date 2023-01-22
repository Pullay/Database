<?php

namespace Pullay\Database\Query;

interface QueryInterface
{
    /**
     * @return array
     */
    public function getValues();

    /**
     * @return string
     */
    public function getSql();
}
