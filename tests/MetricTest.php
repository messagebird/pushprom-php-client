<?php

use PHPUnit\Framework\TestCase;

class ConnectionStub extends stdClass
{
    public function push($delta)
    {
        $this->recordedDelta = $delta;
    }
}


class MetricTest extends TestCase
{
    public function testProxy()
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

            $klass     = ucfirst($type);
            $fullKlass = "pushprom\\$klass";
            $rc        = new ReflectionClass($fullKlass);
            $mo        = $rc->newInstanceArgs([$stub, "name_$i", "help_$i", ["key_$i" => "value_$i"]]);

            $j = 1;
            foreach ($methods as $method) {
                $value = $i * $j * 7.3;
                if (in_array($method, $valuelessMethods)) {
                    $mo->$method();
                } else {
                    $mo->$method($value);
                }

                $expected = [
                    "type"   => $type,
                    'name'   => $name,
                    'help'   => $help,
                    'labels' => $labels,
                    'method' => $method,
                ];
                if (in_array($method, $valuelessMethods) == false) {
                    $expected['value'] = $value;
                }

                $this->assertEquals($stub->recordedDelta, $expected);
            }

            $i++;
        }
    }
}
