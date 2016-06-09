<?php

namespace pushprom;

class Gauge extends Metric
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

    function dec()
    {
        return $this->pushDelta(
            [
                "method" => "dec",
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

    function sub($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "sub",
            ]
        );
    }
}
