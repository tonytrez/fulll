<?php

namespace Fulll\App\Command;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Vehicle;

/**
 * class RegisterVehicleCommand
 */
readonly class RegisterVehicleCommand
{
    /**
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     */
    public function __construct(
        private Fleet $fleet,
        private Vehicle $vehicle
    ) {
    }

    /**
     * @return Fleet
     */
    public function getFleet(): Fleet
    {
        return $this->fleet;
    }

    /**
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }
}
