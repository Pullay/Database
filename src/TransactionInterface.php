<?php

namespace Pullay\Database;

interface TransactionInterface
{
     public function beginTransaction(): bool;
     public function commit(): bool;
     public function rollBack(): bool;
}
