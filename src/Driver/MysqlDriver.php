<?php

namespace Pullay\Database\Driver;

use PDO;

use function sprintf;

class MysqlDriver extends PdoDriver
{
    /**
     * @param string $host
     * @param string $dbname
     * @param string $username
     * @param string|null $password
     * @param array|null $options
     * @return self
     */
    public static function connect($host, $dbname, $username, $password = null, $options = null)
    {
        if (!isset($options[PDO::ATTR_DEFAULT_FETCH_MODE])) {
            $options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
        }

        return new self(sprintf('mysql:host=%1$s;dbname=%2$s', $host, $dbname), $username, $password, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDrivername()
    {
        return 'mysql';
    }
}
