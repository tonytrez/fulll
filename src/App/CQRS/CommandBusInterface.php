<?php

namespace Fulll\App\CQRS;

interface CommandBusInterface
{
    /**
     * @param object $message
     * @param array  $stamps
     */
    public function dispatch(object $message, array $stamps = []);
}