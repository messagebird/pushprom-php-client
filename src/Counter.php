<?php

namespace pushprom;

class Counter extends Metric
{
    /**
     * @param mixed $value
     * @return bool|string|null
     */
    public function set($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "set",
            ]
        );
    }

    /** @return bool|string|null */
    public function inc()
    {
        return $this->pushDelta(
            [
                "method" => "inc",
            ]
        );
    }

    /**
     * @param mixed $value
     * @return bool|string|null
     */
    public function add($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "add",
            ]
        );
    }
}
