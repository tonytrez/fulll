<?php

namespace Fulll\Infra\CQRS;

use Fulll\App\CQRS\QueryBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * class QueryBus
 */
class QueryBus implements QueryBusInterface
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
