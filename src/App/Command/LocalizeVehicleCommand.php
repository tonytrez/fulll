<?php

namespace Fulll\App\Command;

use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\ValueObject\Location;

/**
 * class LocalizeVehicleCommand
 */
readonly class LocalizeVehicleCommand
{
    /**
     * @param Vehicle  $vehicle
     * @param Location $location
     */
    public function __construct(
        private Vehicle $vehicle,
        private Location $location
    ) {
    }

    /**
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }
}
