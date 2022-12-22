<?php

namespace Pullay\Database\Driver;

use PDO;

use function sprintf;

class PdoSqlite extends BasePdo
{
    public static function connection(string $database): self
    {
        return new self(sprintf('sqlite:%s', $database), null, null, [
             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
