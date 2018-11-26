<?php

namespace pushprom;

class Histogram extends Metric
{
    function observe($value, $buckets = [])
    {
        $attrs = [
            'value' => $value,
            'method' => 'observe',
        ];

        if (!empty($buckets)) {
            $attrs['buckets'] = $buckets;
        }

        return $this->pushDelta(
            $attrs
        );
    }
}
