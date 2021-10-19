<?php

namespace pushprom;

class Metric
{
    protected $connection;
    protected $name;
    protected $help;
    protected $labels;
    protected $useUDP;

    function __construct($connection, $name, $help, $labels = [])
    {
        $this->connection = $connection;
        $this->name       = $name;
        $this->help       = $help;
        $this->labels     = $labels;

        $allowedConnectionTypes = ['pushprom\yii2\ConnectionProxy', 'pushprom\Connection'];
        if ($connection == null) {
            throw new \Exception(
                'The first argument needs to be one of ' . implode(", ", $allowedConnectionTypes) . "."
            );
        }

        if (empty($this->name)) {
            throw new \Exception("metric Name can't be empty.");
        }

        if (empty($this->help)) {
            throw new \Exception("metric Help can't be empty.");
        }
    }

    function pushDelta($attrs = [])
    {
        // create new delta based on this metric
        $typeParts = explode('\\', strtolower(get_class($this)));
        $delta     = array_merge(
            [
                "type" => $typeParts[sizeof($typeParts) - 1],
                "name" => $this->name,
                "help" => $this->help,
                "labels" => $this->labels,
            ],
            $attrs
        );

        // ensure that the value is a float
        if (isset($delta["value"])) {
            $delta["value"] = floatval($delta["value"]);
        }

        if (sizeof($delta["labels"]) > 0) {
            // ensure all label values are "strings"
            foreach ($delta["labels"] as $k => $v) {
                $delta["labels"][$k] = "" . $v;
            }
        }

        return $this->connection->push($delta);
    }
}
