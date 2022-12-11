<?php

namespace Pullay\Database\Query;

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
        $this->numberRows = $numberRows;
        return $this;
    }

    public function getNumberRows(): ?int
    {
        return $this->numberRows;
    }

    public function skip(int $offsetValue): self
    {
        $this->offsetValue = $offsetValue;
        return $this;
    }

    public function getOffsetValue(): ?int
    {
        return $this->offsetValue;
    }
}
