<?php

namespace Pullay\Database\Query\Traits;

trait JoinTrait
{
     protected array $join = [];

     public function getJoin(): array
     {
         return $this->join;
     }

     public function resetJoin(): self
     {
         $this->join = [];
         return $this;
     }

     protected function addJoin(string $name, string $on, string $columns, string $type): void
     {
         $this->join = [$name, $on, $columns, $type];
     }

     protected function getClauseJoin(): string
     {
         return '';
     }
}