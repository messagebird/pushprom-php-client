<?php

namespace pushprom;

class Counter extends Metric
{
    public function set($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "set",
            ]
        );
    }

    public function inc()
    {
        return $this->pushDelta(
            [
                "method" => "inc",
            ]
        );
    }

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
