<?php

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Repository\FleetRepositoryInterface;

/**
 * class FleetRepository
 */
class FleetRepository implements FleetRepositoryInterface
{
    /**
     * @param Fleet $fleet
     *
     * @return void
     */
    public function save(Fleet $fleet): void
    {
        // persist entity to db
    }
}