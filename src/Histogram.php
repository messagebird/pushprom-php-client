<?php

namespace pushprom;

class Histogram extends Metric
{
    public function observe($value, $buckets = [])
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
