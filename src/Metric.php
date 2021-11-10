<?php

namespace pushprom;

abstract class Metric
{
    /** @var mixed|\pushprom\Connection */
    protected $connection;

    /** @var string */
    protected $name;

    /** @var string */
    protected $help;

    /** @var array */
    protected $labels;

    /** @var bool */
    protected $useUDP;

    /**
     * @param mixed|\pushprom\Connection $connection
     * @param string $name
     * @param string $help
     * @param array $labels
     * @throws \Exception
     */
    public function __construct($connection, string $name, string $help, array $labels = [])
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

    /** @return bool|string|null */
    public function pushDelta(array $attrs = [])
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
            foreach ($delta["labels"] as $k => $v) {
                $delta["labels"][$k] = (string) $v;
            }
        }

        return $this->connection->push($delta);
    }
}
