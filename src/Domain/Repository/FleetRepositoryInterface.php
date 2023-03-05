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
}