<?php

namespace pushprom;

class Gauge extends Metric
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

    public function dec()
    {
        return $this->pushDelta(
            [
                "method" => "dec",
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
