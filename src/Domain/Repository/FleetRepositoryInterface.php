<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Entity\Fleet;

interface FleetRepositoryInterface
{
    /**
     * @param Fleet $fleet
     *
     * @return void
     */
    public function save(Fleet $fleet): void;

    /**
     * @param int $fleetId
     *
     * @return ?Fleet
     */
    public function getById(int $fleetId): ?Fleet;
}
