<?php

namespace Pullay\Database\Query\Traits;

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

    public function getNumberRows(): ?int
    {
        return $this->numberRows;
    }

    public function getOffsetValue(): ?int
    {
        return $this->offsetValue;
    }

    protected function getClauseLimit(): string
    {
        return (!empty($this->numberRows) ? sprintf(
             ' LIMIT %1$s %2$s', $this->numberRows, 
             (!empty($this->offsetValue) ? sprintf(' OFFSET %1$s', $this->offsetValue) : '')
        ) : '');
    }
}