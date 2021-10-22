<?php

use PHPUnit\Framework\TestCase;

class ConnectionStub extends stdClass
{
    /** @param mixed $delta */
    public function push($delta): void
    {
        $this->recordedDelta = $delta;
    }
}


class MetricTest extends TestCase
{
    public function testProxy(): void
    {
        $stub = new ConnectionStub();

        $types            = [
            "counter"   => ["set", "add", "inc"],
            "gauge"     => ["set", "add", "inc", "dec"],
            "histogram" => ["observe"],
            "summary"   => ["observe"],
        ];
        $valuelessMethods = ["inc", "dec"];

        $i = 1;
        foreach ($types as $type => $methods) {

            $name   = "name_$i";
            $help   = "help_$i";
            $labels = ["key_$i" => "value_$i"];

            $class     = ucfirst($type);
            /** @var class-string $fullClass */
            $fullClass = "pushprom\\$class";
            $rc        = new ReflectionClass($fullClass);
            $metric    = $rc->newInstanceArgs([$stub, "name_$i", "help_$i", ["key_$i" => "value_$i"]]);

            $j = 1;
            foreach ($methods as $method) {
                $value = $i * $j * 7.3;
                if (in_array($method, $valuelessMethods)) {
                    $metric->$method();
                } else {
                    $metric->$method($value);
                }

                $expected = [
                    "type"   => $type,
                    'name'   => $name,
                    'help'   => $help,
                    'labels' => $labels,
                    'method' => $method,
                ];
                if (in_array($method, $valuelessMethods) === false) {
                    $expected['value'] = $value;
                }
                if ($type === 'histogram') {
                    $expected['buckets'] = [];
                }

                $this->assertEquals($expected, $stub->recordedDelta);
            }

            $i++;
        }
    }
}
