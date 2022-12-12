<?php

namespace Pullay\Database\Query;

trait JoinTrait
{
     protected array $joins = [];

     public function join(string $tableName, string $condition, $type = 'INNER')
     {
         $this->joins[] = [$tableName, $condition, $type];
     }

     public function innerJoin(string $tableName, string $condition): self
     {
         $this->join($tableName, $condition, 'INNER');
         return $this;
     }

     public function leftJoin(string $tableName, string $condition): self
     {
         $this->join($tableName, $condition, 'LEFT');
         return $this;
     }

     public function rightJoin(string $tableName, string $condition)
     {
         $this->join($tableName, $condition, 'RIGHT');
     }

     public function getjoins(): array
     {
         return $this->joins;
     }
}
