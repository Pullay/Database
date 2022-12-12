<?php

namespace Pullay\Database\Driver;

use Pullay\Database\TransactionInterface;

interface DriverInterface extends TransactionInterface
{
    public function prepareQuery(string $sql, array $values = []): self;

    /**
     * @return int|false
     */
    public function lastInsertedId();
    public function fetchOne(): ?array;
    public function fetchAll(): array;

    /**
     * @return mixed
     */
    public function fetchColumn();
    public function rowCount(): int;
}
