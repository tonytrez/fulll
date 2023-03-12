<?php

namespace Fulll\App\CQRS;

interface QueryBusInterface
{
    /**
     * @param object $message
     * @param array  $stamps
     */
    public function dispatch(object $message, array $stamps = []);
}
