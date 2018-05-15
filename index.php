<?php
/**
 * base vehicle capabilities
 * Interface VehicleInterface
 */
interface VehicleBaseInterface
{
    public function emptyLoads(string $object);
    public function refuel($object);
    public function stop();
}

/**
 * capabilities specified for wather Vehicle
 * Interface WatherVehicleInterface
 */
interface WatherVehicleInterface
{
    public function swim();
}

/**
 * capabilities specified for air Vehicle
 * Interface FlyVehicleInterface
 */
interface FlyVehicleInterface
{
    public function takeOff();
    public function fly();
    public function landing();
}

/**
 * capabilities specified for road Vehicles
 * Interface RoadVehicleInterface
 */
interface RoadVehicleInterface
{
    public function move();
}

/**
 * Interface LeisureVehicleInterface
 */
interface LeisureVehicleInterface
{
    public function musicOn();
}


    /**
 * Class WatherVehicleTypes
 */
final class WatherVehicleTypes
{
    const TYPES = [
        'boat',
        'vessel',
        'yacht',
    ];
}

/**
 * Class FlyVehicleTypes
 */
final class FlyVehicleTypes
{
    const TYPES = [
        'helicopter',
        'aircraft',
    ];
}

/**
 * Class RoadVehicleTypes
 */
final class RoadVehicleTypes
{
    const TYPES = [
        'bmw',
        'kamaz',
    ];
}

/**
 * base vehicle strategy
 * Class VehicleBase
 */
class VehicleBase implements VehicleBaseInterface
{
    public $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function musicOn()
    {
        echo $this->vehicle->getName() . ' music switched on <br>';
    }

    public function emptyLoads(string $object)
    {
        echo $this->vehicle->getName() . ' refuel ' . $object .' <br>';
    }

    public function refuel($object)
    {
        echo $this->vehicle->getName() . ' refuel ' . $object .' <br>';
    }

    public function stop()
    {
        echo $this->vehicle->getName() . ' stopped <br>';
    }

    public function __call($method, $arguments)
    {
        throw new \Exception('sorry, the "'.$this->vehicle->getName().'" can\'t "'. $method.'"');
    }
}

/**
 *  wather vehicle strategy
 * Class WatherVehicle
 */
class WatherVehicle extends VehicleBase implements WatherVehicleInterface
{
    public function swim()
    {
        echo $this->vehicle->getName() . ' swimming <br>';
    }
}

/**
 * air vehicle strategy
 * Class FlyVehicle
 */
class FlyVehicle extends VehicleBase implements FlyVehicleInterface
{
    public function takeOff()
    {
        echo $this->vehicle->getName() . ' took off <br>';
    }

    public function fly()
    {
        echo $this->vehicle->getName() . ' flying  <br>';
    }

    public function landing()
    {
        echo $this->vehicle->getName() . ' landing <br>';
    }
}

/**
 * road vehicle strategy
 * Class RoadVehicle
 */
class RoadVehicle extends VehicleBase implements RoadVehicleInterface
{
    public function move()
    {
        echo $this->vehicle->getName() . ' moveing <br>';
    }
}

/**
 * vehicle factory
 * Class VehicleManager
 */
class VehicleManager
{
    public function init(Vehicle $vehicle)
    {
        if (in_array($vehicle->getName(), WatherVehicleTypes::TYPES)) {
            return new WatherVehicle($vehicle);
        }

        if (in_array($vehicle->getName(), FlyVehicleTypes::TYPES)) {
            return new FlyVehicle($vehicle);
        }

        if (in_array($vehicle->getName(), RoadVehicleTypes::TYPES)) {
            return new RoadVehicle($vehicle);
        }

        throw new \Exception('sorry, vehicle type "'.$vehicle->name.'" is undefiend');
    }
}

/**
 * Class Vehicle
 */
class Vehicle
{
    protected $name;
    public $strategy;

    public function __construct($name)
    {
        $this->name = $name;

        $manager = new VehicleManager;
        $this->strategy = $manager->init($this);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}

$vehicles = [
    new Vehicle('bmw'), new Vehicle('boat'), new Vehicle('helicopter'), new Vehicle('kamaz')
];

foreach ($vehicles as $vehicle) {
    switch ($vehicle->getName()) {
        case 'bmw':
            $vehicle->strategy->move();
            $vehicle->strategy->musicOn();
            break;
        case 'boat':
            $vehicle->strategy->swim();
            break;
        case 'helicopter':
            $vehicle->strategy->takeOff();
            $vehicle->strategy->fly();
            $vehicle->strategy->landing();
            break;
        case 'kamaz':
            $vehicle->strategy->move();
            $vehicle->strategy->emptyLoads('diesel');
            break;
    }

    $vehicle->strategy->stop();
    $vehicle->strategy->refuel('gas');
    echo('-----------<br>');
}


