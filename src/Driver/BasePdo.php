<?php

namespace Pullay\Database\Driver;

use PDO;
use PDOStatement;

abstract class BasePdo implements DriverInterface
{
    /**
     * Fetch mode
     */
    public const FETCH_ASSOC = PDO::FETCH_ASSOC;
    public const FETCH_BOTH  = PDO::FETCH_BOTH;
    public const FETCH_CLASS = PDO::FETCH_CLASS;
    public const FETCH_NUM   = PDO::FETCH_NUM;
    public const FETCH_OBJ   = PDO::FETCH_OBJ;

    protected PDO $pdo;
    protected ?PDOStatement $statement;

    public function __construct(string $dns, ?string $user = null, ?string $password = null, ?array $options = null)
     {
        if (!isset($options[PDO::ATTR_ERRMODE])) {
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        }

        $this->pdo = new PDO($dns, $user, $password, $options);
    }

    public function setPdo(PDO $pdo): self
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getServerVersion(): string
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function getClientVersion(): string 
    {
        return $this->pdo->getAttribute(PDO::ATTR_CLIENT_VERSION);
    }

    public function prepareQuery(string $sql, array $values = []): self
    {
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->execute($values);
        return $this;
    }

    public function getStatement(): ?PDOStatement
    {
        return $this->statement;
    }

    public function reset(): void
    {
        $this->statement = null;
    }

    public function lastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }

    public function fetchOne(int $mode = self::FETCH_ASSOC): ?array
    {
        $row = $this->statement->fetch($mode);
        return $row !== false ? $row : null;
    }

    public function fetchAll(int $mode = self::FETCH_ASSOC): array
    {
        $rows = $this->statement->fetchAll($mode);
        return $rows;
    }

    public function fetchColumn()
    {
        $result = $this->statement->fetchColumn();
        return $result;
    }

    public function rowCount(): int
    {
        $result = $this->statement->rowCount();
        return $result;
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }
}
