<?php

namespace Pullay\Database\Query;

trait LimitTrait
{
    /**
     * @var int|null
     */
    protected $numberRows = null;

    /**
     * @var int|null
     */
    protected $offsetValue = null;

    /**
     * @param int $numberRows
     * @param int|null $offsetValue
     * @return self
     */
    public function limit($numberRows, $offsetValue = null)
    {
        $this->numberRows = $numberRows;
        $this->offsetValue = $offsetValue;
        return $this;
    }

    /**
     * @param int $numberRows
     * @return self
     */
    public function take($numberRows)
    {
        $this->numberRows = $numberRows;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumberRows()
    {
        return $this->numberRows;
    }

    /**
     * @param int|null $offsetValue
     * @return self
     */
    public function skip($offsetValue)
    {
        $this->offsetValue = $offsetValue;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffsetValue()
    {
        return $this->offsetValue;
    }
}
