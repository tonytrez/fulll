<?php

namespace Fulll\Ui\Command;

use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Infra\CQRS\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'fulll:fleet:register-vehicle', description: 'Command to register a vehicle in a fleet')]
class RegisterVehicleCommandCli extends Command
{
    /**
     * @param CommandBus $commandBus
     */
    public function __construct(private readonly CommandBus $commandBus)
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet id for register');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle\'s plate number to register');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->commandBus->dispatch(
                new RegisterVehicleCommand(
                    $input->getArgument('fleetId'),
                    $input->getArgument('vehiclePlateNumber')
                )
            );
        } catch (\Throwable $exception) {
            $output->writeln($exception->getMessage());

            return 1;
        }

        $output->writeln('Vehicle has been registered to the fleet.');
        return 0;
    }
}
