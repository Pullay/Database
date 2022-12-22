<?php

namespace Pullay\Database\Query;

use Pullay\Database\Connection;

use function sprintf;
use function strtoupper;

class Delete extends BaseQuery
{
    use WhereTrait;
    use LimitTrait;

    protected Connection $connection;
    protected array $values = [];

    public function __construct(Connection $connection, ?string $tableName = null)
    {
        $this->connection = $connection;

        if ($tableName) {
            $this->from($tableName);
        }
    }

    public function from(string $tableName): self
    {
        $this->setTableName($tableName);
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getSql(): string
    {
        $sql = sprintf('DELETE FROM %1$s', $this->tableName);

        if (!empty($this->whereConditions)) {
           $i = 0;

           foreach($this->whereConditions as $whereCondition) {
               [$condition, $parameters, $statement] = $whereCondition;
               $this->values += $parameters;
               $clause = ($i === 0 ? 'WHERE': strtoupper($statement));
               $sql .= sprintf(" %s %s", $clause, $condition);
               $i++;
           }
        }

        if (!empty($this->numberRows)) {
            $sql .= sprintf(' LIMIT %1$s', $this->numberRows);

            if (!empty($this->offsetValue)) {
                $sql =  sprintf(' LIMIT %1$s OFFSET %2$s', $this->numberRows, $this->offsetValue);
            }
        }

        return $sql;
    }

    /**
     * @return int|false
     */
    public function execute()
    {
        $result = $this->connection
           ->setQueryStatement($this)
           ->execute();

        if ($result) {
            return $result->rowCount();
        }

        return false;
    }
}
