<?php

namespace Fulll\Domain\Entity;

/**
 * class Fleet
 */
class Fleet
{
    /**
     * @var Vehicle[]
     */
    private array $vehicles;

    /**
     * @var User
     */
    private User $user;

    /**
     * Fleet Constructor
     */
    public function __construct(User $user)
    {
        $this->vehicles = [];
        $this->user     = $user;
    }

    /**
     * @return array
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    /**
     * @param Vehicle $vehicle
     *
     * @return void
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles[] = $vehicle;
    }
}
