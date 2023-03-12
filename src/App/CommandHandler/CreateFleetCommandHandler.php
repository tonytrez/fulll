<?php

namespace Fulll\App\CommandHandler;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Fulll\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateFleetCommandHandler
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly UserRepositoryInterface  $userRepository,
    ) {
    }

    /**
     * @param CreateFleetCommand $command
     *
     * @return int
     */
    public function __invoke(CreateFleetCommand $command): int
    {
        $user = $this->userRepository->getById($command->getUserId());
        $fleet = new Fleet();
        $fleet->setUser($user);
        $this->fleetRepository->save($fleet);

        return $fleet->getId();
    }
}
