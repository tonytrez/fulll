<?php

namespace Fulll\App\CommandHandler;

use Fulll\App\Command\LocalizeVehicleCommand;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Fulll\Domain\Repository\VehicleRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class ParkVehicleCommandHandler
 */
#[AsMessageHandler]
class LocalizeVehicleCommandHandler
{
    /**
     * @param VehicleRepositoryInterface $vehicleRepository
     * @param FleetRepositoryInterface   $fleetRepository
     */
    public function __construct(
        private readonly VehicleRepositoryInterface $vehicleRepository,
        private readonly FleetRepositoryInterface   $fleetRepository,
    ) {
    }

    /**
     * @param LocalizeVehicleCommand $command
     *
     * @return void
     */
    public function __invoke(LocalizeVehicleCommand $command): void
    {
        $fleet = $this->fleetRepository->getById($command->getFleetId());
        if (null === $fleet) {
            throw new \RuntimeException('Fleet not found');
        }
        $vehicle = null;
        foreach ($fleet->getVehicles() as $fleetVehicle) {
            if ($fleetVehicle->getPlateNumber() === $command->getVehiclePlateNumber()) {
                $vehicle = $fleetVehicle;
            }
        }
        if (null === $vehicle) {
            throw new \RuntimeException('Vehicle not found in the fleet');
        }
        $location = $command->getLocation();
        if ($vehicle->getLocation() == $location) {
            throw new \RuntimeException('Vehicle already localize at this place');
        }
        $vehicle->setLocation($location);
        $this->vehicleRepository->save($vehicle);
    }
}
