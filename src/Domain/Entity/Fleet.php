<?php

namespace Fulll\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\PersistentCollection;
use Fulll\Domain\Repository\FleetRepositoryInterface;

#[Entity(repositoryClass: FleetRepositoryInterface::class)]
class Fleet
{
    /**
     * @var int|null
     */
    #[Id]
    #[GeneratedValue]
    #[Column]
    private ?int $id = null;

    /**
     * @var ArrayCollection|PersistentCollection
     *
     */
    #[ManyToMany(targetEntity: Vehicle::class, cascade: ['persist'])]
    private ArrayCollection|PersistentCollection $vehicles;

    /**
     * @var User
     */
    #[ManyToOne(targetEntity: User::class)]
    private User $user;

    /**
     * Fleet Constructor
     */
    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|PersistentCollection
     */
    public function getVehicles(): ArrayCollection|PersistentCollection
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

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
