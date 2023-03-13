<?php

namespace Fulll\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Fulll\Domain\Repository\VehicleRepositoryInterface;
use Fulll\Domain\ValueObject\Location;

/**
 * class Vehicle
 */
#[Entity(repositoryClass: VehicleRepositoryInterface::class)]
class Vehicle
{
    /**
     * @var int|null
     */
    #[Id]
    #[GeneratedValue]
    #[Column]
    private ?int $id = null;

    /**
     * @var string
     */
    #[Column(length: 20, unique: true)]
    private string $plateNumber;

    /**
     * @var Location|null
     */
    #[Column(type: 'location_type' ,nullable: true)]
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

    /**
     * @return string
     */
    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }
}
