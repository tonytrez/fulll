<?php

namespace Fulll\Domain\Entity;

use Fulll\Domain\ValueObject\Location;

/**
 * class Vehicle
 */
class Vehicle
{
    /**
     * @var string
     */
    private string $plateNumber;

    /**
     * @var Location|null
     */
    private Location|null $location;

    /**
     * @param string        $plateNumber
     * @param Location|null $location
     */
    public function __construct(string $plateNumber, Location|null $location = null)
    {
        $this->plateNumber = $plateNumber;
        $this->location    = $location;
    }

    /**
     * @return Location|null
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location|null $location
     */
    public function setLocation(?Location $location): void
    {
        $this->location = $location;
    }
}
