<?php

namespace pushprom;

class Summary extends Metric
{
    /**
     * @param mixed $value
     * @return bool|string|null
     */
    public function observe($value)
    {
        return $this->pushDelta(
            [
                "value"  => $value,
                "method" => "observe",
            ]
        );
    }
}
