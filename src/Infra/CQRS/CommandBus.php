<?php

namespace Fulll\Infra\CQRS;

use Fulll\App\CQRS\CommandBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * class CommandBus
 */
class CommandBus implements CommandBusInterface
{
    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    /**
     * @param object $message
     * @param array  $stamps
     *
     * @return Envelope
     */
    public function dispatch(object $message, array $stamps = []): Envelope
    {
        return $this->messageBus->dispatch($message, $stamps);
    }
}