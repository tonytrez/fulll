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
     * @param int    $fleetId
     * @param string $vehiclePlateNumber
     */
    public function __construct(
        private int $fleetId,
        private string $vehiclePlateNumber
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
}
