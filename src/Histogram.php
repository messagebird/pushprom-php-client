<?php

namespace pushprom;

class Histogram extends Metric
{
    /**
     * @param mixed $value
     * @param array $buckets
     * @return bool|string|null
     */
    public function observe($value, array $buckets = [])
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
