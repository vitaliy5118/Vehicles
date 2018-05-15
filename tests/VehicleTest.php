<?php

namespace tests;

require_once dirname(__FILE__) . '/../index.php';

use PHPUnit\Framework\TestCase;
use Vehicle;
use FuelTypes;

class VehicleTest extends TestCase
{
    public function setUp()
    {
        $this->bmw = new Vehicle('bmw');
        $this->kamaz = new Vehicle('kamaz');
    }

    public function testName()
    {
        $this->assertEquals('bmw', $this->bmw->getName());
        $this->assertEquals('kamaz', $this->kamaz->getName());
    }

    public function testMoving()
    {
        $this->expectOutputString('bmw moveing <br>');
        $this->bmw->strategy->move();
    }

    public function testFuel()
    {
        $this->expectOutputString('kamaz refuel diesel <br>');
        $this->kamaz->strategy->refuel(FuelTypes::DIESEL);
    }


}