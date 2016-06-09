<?php

namespace pushprom;

class Summary extends Metric
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
