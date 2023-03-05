<?php

namespace Fulll\App\CommandHandler;

use Exception;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Domain\Repository\FleetRepositoryInterface;

/**
 * class RegisterVehicleCommandHandler
 */
class RegisterVehicleCommandHandler
{
    public function __construct(private FleetRepositoryInterface $fleetRepository)
    {
    }

    /**
     * @param RegisterVehicleCommand $command
     *
     * @return void
     * @throws Exception
     */
    public function handle(RegisterVehicleCommand $command): void
    {
        $fleet   = $command->getFleet();
        $vehicle = $command->getVehicle();
        if (in_array($vehicle, $fleet->getVehicles())) {
            throw new Exception('Ce véhicule est déjà enregistré dans votre flotte.');
        }
        $fleet->addVehicle($vehicle);
        $this->fleetRepository->save($fleet);
    }
}
