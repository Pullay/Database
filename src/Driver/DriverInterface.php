<?php

namespace Pullay\Database\Driver;

use Pullay\Database\TransactionInterface;

interface DriverInterface extends TransactionInterface
{
     public function prepareQuery(string $sql, array $values = []): self;
     public function fetchOne(): ?array;
     public function fetchAll(): array;
     public function lastInsertedId();
}