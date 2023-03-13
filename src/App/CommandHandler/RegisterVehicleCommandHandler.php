<?php

namespace Fulll\App\CommandHandler;

use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Exception;
use Fulll\Domain\Repository\VehicleRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * class RegisterVehicleCommandHandler
 */
#[AsMessageHandler]
class RegisterVehicleCommandHandler
{
    public function __construct(
        private readonly FleetRepositoryInterface   $fleetRepository,
        private readonly VehicleRepositoryInterface $vehicleRepository,
    ) {
    }

    /**
     * @param RegisterVehicleCommand $command
     *
     * @return void
     * @throws Exception
     */
    public function __invoke(RegisterVehicleCommand $command): void
    {
        $fleet   = $this->fleetRepository->getById($command->getFleetId());
        $vehicle = $this->vehicleRepository->getByPlateNumber($command->getVehiclePlateNumber()) ?? new Vehicle($command->getVehiclePlateNumber());
        foreach ($fleet->getVehicles() as $vehicleInFleet) {
            if ($vehicle->getPlateNumber() === $vehicleInFleet->getPlateNumber()) {
                throw new Exception('This Vehicle is already registered in this fleet');
            }
        }
        $fleet->addVehicle($vehicle);
        $this->fleetRepository->save($fleet);
    }
}
