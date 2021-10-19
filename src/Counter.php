<?php

namespace pushprom;

class Counter extends Metric
{
    function set($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "set",
            ]
        );
    }

    function inc()
    {
        return $this->pushDelta(
            [
                "method" => "inc",
            ]
        );
    }

    function add($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "add",
            ]
        );
    }
}
