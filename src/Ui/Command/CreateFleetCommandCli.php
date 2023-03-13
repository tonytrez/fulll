<?php

namespace Fulll\Ui\Command;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\CQRS\CommandBusInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

#[AsCommand(name: 'fulll:fleet:create', description: 'command to create a fleet')]
class CreateFleetCommandCli extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->addArgument('userId', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $envelope = $this->commandBus->dispatch(new CreateFleetCommand($input->getArgument('userId')));
        $handleStamp = $envelope->last(HandledStamp::class);

        $output->writeln(sprintf('Fleet #%d has been created', $handleStamp->getResult()));

        return 0;
    }
}
