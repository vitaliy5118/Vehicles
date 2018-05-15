<?php

/**
 * base vehicle capabilities
 * Interface VehicleInterface
 */
interface VehicleBaseInterface
{
    public function emptyLoads($fuel);
    public function refuel($fuel);
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
 * Interface EnumerationInterface
 */
interface  EnumerationInterface
{
    public static function getItems(): array;
}

    /**
     * Class WatherVehicleTypes
     */
final class WatherVehicleTypes implements EnumerationInterface
{
    const BOAT = 'boat';
    const VESSEL = 'vessel';
    const YACHT = 'yacht';

    /**
     * @return array
     */
    public static function getItems(): array
    {
        return [
            self::BOAT,
            self::VESSEL,
            self::YACHT
        ];
    }
}

/**
 * Class FlyVehicleTypes
 */
final class FlyVehicleTypes implements EnumerationInterface
{
    const HELICOPTER = 'helicopter';
    const AIRCRAFT = 'aircraft';

    /**
     * @return array
     */
    public static function getItems(): array
    {
        return [
            self::HELICOPTER,
            self::AIRCRAFT,
        ];
    }
}

/**
 * Class RoadVehicleTypes
 */
final class RoadVehicleTypes implements EnumerationInterface
{
    const BMW = 'bmw';
    const KAMAZ = 'kamaz';

    /**
     * @return array
     */
    public static function getItems(): array
    {
        return [
            self::BMW,
            self::KAMAZ,
        ];
    }
}

/**
 * Class RoadVehicleTypes
 */
final class FuelTypes implements EnumerationInterface
{
    const GAS = 'gas';
    const DIESEL = 'diesel';
    const KEROSENE = 'kerosene';

    /**
     * @return array
     */
    public static function getItems(): array
    {
        return [
            self::GAS,
            self::DIESEL,
            self::KEROSENE,
        ];
    }
}

/**
 * base vehicle strategy
 * Class VehicleBase
 */
class VehicleBase implements VehicleBaseInterface, LeisureVehicleInterface
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

    public function emptyLoads($fuel)
    {
        echo $this->vehicle->getName() . ' empty loads ' . $fuel .' <br>';
    }

    public function refuel($fuel)
    {
        echo $this->vehicle->getName() . ' refuel ' . $fuel .' <br>';
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
class VehicleTypist
{
    public function getStrategy(Vehicle $vehicle)
    {
        if (in_array($vehicle->getName(), WatherVehicleTypes::getItems())) {
            return new WatherVehicle($vehicle);
        }

        if (in_array($vehicle->getName(), FlyVehicleTypes::getItems())) {
            return new FlyVehicle($vehicle);
        }

        if (in_array($vehicle->getName(), RoadVehicleTypes::getItems())) {
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

        $strategy = new VehicleTypist;
        $this->strategy = $strategy->getStrategy($this);
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
            $vehicle->strategy->stop();
            break;
        case 'helicopter':
            $vehicle->strategy->takeOff();
            $vehicle->strategy->fly();
            $vehicle->strategy->landing();
            break;
        case 'kamaz':
            $vehicle->strategy->move();
            $vehicle->strategy->stop();
            $vehicle->strategy->emptyLoads(FuelTypes::DIESEL);
            $vehicle->strategy->refuel(FuelTypes::DIESEL);
            break;
    }

    echo('-----------<br>');
}



