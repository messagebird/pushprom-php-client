<?php

namespace pushprom;

class Histogram extends Metric
{
    function observe($value, $buckets = [])
    {
        return $this->pushDelta(
            [
                'value' => $value,
                'method' => 'observe',
                'buckets' => $buckets,
            ]
        );
    }
}
