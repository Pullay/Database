<?php

namespace Pullay\Database\Query\Traits;

use function sprintf;

trait LimitTrait
{
    protected ?int $numberRows = null;
    protected ?int $offsetValue = null;

    public function limit(int $numberRows, ?int $offsetValue = null): self
    {
        $this->numberRows = $numberRows;
        $this->offsetValue = $offsetValue;
        return $this;
    }

    public function take(int $numberRows): self
    {
        return $this->limit($numberRows);
    }

    public function getNumberRows(): ?int
    {
        return $this->numberRows;
    }

    public function getTake(): ?int
    {
        return $this->getNumberRows();
    }

    public function offset(int $offsetValue): self
    {
        $this->offsetValue = $offsetValue;
        return $this;
    }

    public function skip(int $offsetValue): self
    {
        return $this->offset($offsetValue);
    }

    public function getOffsetValue(): ?int
    {
        return $this->offsetValue;
    }

    public function getSkip(): ?int
    {
        return $this->getOffsetValue();
    }

    protected function getClauseLimit(): string
    {
        $sql = '';

        if (!empty($this->numberRows)) {
            $sql = sprintf(' LIMIT %1$s', $this->numberRows);

            if (!empty($this->offsetValue)) {
                $sql =  sprintf(' LIMIT %1$s OFFSET %2$s', $this->numberRows, $this->offsetValue);
            }
        }

        return $sql;
    }
}