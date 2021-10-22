<?php

namespace pushprom;

class Gauge extends Metric
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

    /** @return bool|string|null */
    public function dec()
    {
        return $this->pushDelta(
            [
                "method" => "dec",
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

    /**
     * @param mixed $value
     * @return bool|string|null
     */
    public function sub($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "sub",
            ]
        );
    }
}
