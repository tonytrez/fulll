<?php

namespace Fulll\App\CommandHandler;

use Fulll\App\Command\LocalizeVehicleCommand;
use Fulll\Domain\Repository\VehicleRepositoryInterface;

/**
 * class VehicleCommandHandler
 */
class LocalizeVehicleCommandHandler
{
    public function __construct(private VehicleRepositoryInterface $vehicleRepository)
    {
    }

    /**
     * @param LocalizeVehicleCommand $command
     *
     * @return void
     */
    public function handle(LocalizeVehicleCommand $command): void
    {
        $vehicle  = $command->getVehicle();
        $location = $command->getLocation();
        if ($vehicle->getLocation() === $location) {
            throw new \RuntimeException('This vehicle is already parked at this location');
        }
        $vehicle->setLocation($location);
        $this->vehicleRepository->save($vehicle);
    }
}
