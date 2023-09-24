<?php

namespace Pullay\Database\Driver;

use PDO;

class PdoDriver implements DriverInterface
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @param string $dns 
     * @param string $user|null
     * @param string $password|null
     * @param array|null $options
     */
    public function __construct($dns, $user = null, $password = null, $options = null)
    {
        if (!isset($options[PDO::ATTR_ERRMODE])) {
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        }

        $this->pdo = new PDO($dns, $user, $password, $options);
    }

    /**
     * @param PDO $pdo
     * @return self
     */
    public function setPdo(PDO $pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }

    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * {@inheritdoc}
     */
    public function getServerVersion()
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    /**
     * {@inheritdoc}
     */
    public function getClientVersion()
    {
        return $this->pdo->getAttribute(PDO::ATTR_CLIENT_VERSION);
    }

    /**
     * {@inheritdoc}
     */
    public function getServerInfo()
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_INFO);
    }

    /**
     * {@inheritdoc}
     */
    public function getDrivername()
    {
        return $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareQuery($sql, $params = [])
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return new PdoResult($statement);
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId()
    {
        $insertId = $this->pdo->lastInsertId();
        return $insertId === false ? 0 : (int) $insertId;
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }
}
