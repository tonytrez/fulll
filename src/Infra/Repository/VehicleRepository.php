<?php

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Repository\VehicleRepositoryInterface;

class VehicleRepository implements VehicleRepositoryInterface
{
    /**
     * @param Vehicle $vehicle
     *
     * @return void
     */
    public function save(Vehicle $vehicle): void
    {
        // persist entity to db
    }
}