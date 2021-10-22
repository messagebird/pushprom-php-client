<?php

namespace pushprom;

class Histogram extends Metric
{
    /**
     * @param mixed $value
     * @param mixed $buckets
     * @return bool|string|null
     */
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
