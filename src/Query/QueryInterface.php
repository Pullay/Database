<?php

namespace Pullay\Database\Query;

interface QueryInterface
{
    public function getValues(): array;
    public function getSql(): string;
}
