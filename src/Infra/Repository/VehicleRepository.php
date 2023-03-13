<?php

namespace Fulll\Infra\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Repository\VehicleRepositoryInterface;

class VehicleRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    /**
     * @param string $vehiclePlateNumber
     *
     * @return Vehicle|null
     * @throws NonUniqueResultException
     */
    public function getByPlateNumber(string $vehiclePlateNumber): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->select('v')
            ->where('v.plateNumber = :vehiclePlateNumber')
            ->setParameter('vehiclePlateNumber', $vehiclePlateNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Vehicle $vehicle
     *
     * @return void
     */
    public function save(Vehicle $vehicle): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($vehicle);
        $entityManager->flush();
    }
}
