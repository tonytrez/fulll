<?php

namespace Fulll\Ui\Command;

use Fulll\App\Command\LocalizeVehicleCommand;
use Fulll\Domain\ValueObject\Location;
use Fulll\Infra\CQRS\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'fulll:fleet:localize-vehicle', description: 'Localize a vehicle with GPS coordinates')]
class LocalizeVehicleCommandCli extends Command
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
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet id');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle\'s plate number');
        $this->addArgument('longitude', InputArgument::REQUIRED, 'Longitude Gps Coordinates');
        $this->addArgument('latitude', InputArgument::REQUIRED, 'Latitude Gps Coordinates');
        $this->addArgument('altitude', InputArgument::OPTIONAL, 'Altitude Gps Coordinates(optional)');
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
                new LocalizeVehicleCommand(
                    $input->getArgument('fleetId'),
                    $input->getArgument('vehiclePlateNumber'),
                    new Location(
                        $input->getArgument('longitude'),
                        $input->getArgument('latitude'),
                        $input->getArgument('altitude'),
                    ),
                )
            );
        } catch (\Throwable $exception) {
            $output->writeln($exception->getMessage());

            return 1;
        }

        $output->writeln('Vehicle location saved');

        return 0;
    }
}