<?php

namespace Pullay\Database\Query;

interface Query
{
    public function getValues(): array;
    public function getSql(): string;
}