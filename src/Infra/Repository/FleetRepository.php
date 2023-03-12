<?php

namespace Fulll\Infra\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Repository\FleetRepositoryInterface;

/**
 * class FleetRepository
 */
class FleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    /**
     * @param Fleet $fleet
     *
     * @return void
     */
    public function save(Fleet $fleet): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($fleet);
        $entityManager->flush();
    }

    /**
     * @param int $fleetId
     *
     * @return ?Fleet
     */
    public function getById(int $fleetId): ?Fleet
    {
        return $this->find($fleetId);
    }
}
