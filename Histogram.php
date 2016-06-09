<?php

namespace pushprom;

class Histogram extends Metric
{
    function observe($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "observe",
            ]
        );
    }
}
