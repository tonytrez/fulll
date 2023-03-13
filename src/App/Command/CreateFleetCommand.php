<?php

namespace Fulll\App\Command;

/**
 * class CreateFleetCommand
 */
readonly class CreateFleetCommand
{
    /**
     * @param int $userId
     */
    public function __construct(
        private int $userId,
    ) {
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
