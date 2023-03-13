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
     * @param int      $fleetId
     * @param string   $vehiclePlateNumber
     * @param Location $location
     */
    public function __construct(
        private int $fleetId,
        private string $vehiclePlateNumber,
        private Location $location
    ) {
    }

    /**
     * @return int
     */
    public function getFleetId(): int
    {
        return $this->fleetId;
    }

    /**
     * @return string
     */
    public function getVehiclePlateNumber(): string
    {
        return $this->vehiclePlateNumber;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }
}
