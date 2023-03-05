<?php

namespace Fulll\App\CommandHandler;

use Fulll\App\Command\ParkVehicleCommand;
use Fulll\Domain\Repository\VehicleRepositoryInterface;

/**
 * class ParkVehicleCommandHandler
 */
class ParkVehicleCommandHandler
{
    public function __construct(private VehicleRepositoryInterface $vehicleRepository)
    {
    }

    /**
     * @param ParkVehicleCommand $command
     *
     * @return void
     */
    public function handle(ParkVehicleCommand $command): void
    {
        $vehicle  = $command->getVehicle();
        $location = $command->getLocation();
        if ($vehicle->getLocation() === $location) {
            throw new \RuntimeException('Ce véhicule est déjà localisé à cet endroit.');
        }
        $vehicle->setLocation($location);
        $this->vehicleRepository->save($vehicle);
    }
}
