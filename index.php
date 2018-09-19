<?php

ini_set('error_reporting', 1);
error_reporting(E_ALL);

interface IVehicle
{
    public function run();

    public function slow();
}

abstract class Vehicle
{
    public $speed;

    protected $max_speed = 0;

    abstract public function run($speed);

    public function getMaxSpeed()
    {
        return $this->max_speed;
    }

    public function setMaxSpeed($max_speed)
    {
        if($max_speed > 0) {
            $this->max_speed = $max_speed;
        }
    }

    public function __construct($max_speed)
    {
        $this->setMaxSpeed($max_speed);
    }
}

class Car extends Vehicle
{

    public function __construct($max_speed)
    {
        parent::__construct($max_speed);
    }

    public function run($speed)
    {
        $this->speed = $speed;
    }
}

class Bus extends Vehicle
{
    public function __construct($max_speed)
    {
        parent::__construct($max_speed);
    }

    public function run($speed)
    {
        $this->speed = $speed;
    }
}

$vehicles = array(new Car(200, 60), new Bus(100, 60));

foreach ($vehicles as $key => $val)
{
    var_dump( $val );
    echo '<br>';
}

echo '<pre>';
print_r($vehicles);
echo '</pre>';