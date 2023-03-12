<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Entity\Vehicle;

interface VehicleRepositoryInterface
{
    /**
     * @param Vehicle $vehicle
     *
     * @return void
     */
    public function save(Vehicle $vehicle): void;
}