<?php

namespace Pullay\Database\Driver;

use PDO;

use function sprintf;

class SqliteDriver extends PdoDriver
{
    /**
     * @param string $database
     * @param array|null $options
     * @return self
     */
    public static function connect($database, $options = null)
    {
        if (!isset($options[PDO::ATTR_DEFAULT_FETCH_MODE])) {
            $options[PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
        }

        return new self(sprintf('sqlite:%s', $database, null, null, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function getDrivername()
    {
        return 'sqlite';
    } 
}
