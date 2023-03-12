<?php

namespace Fulll\Infra\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fulll\Domain\Entity\User;
use Fulll\Domain\Repository\UserRepositoryInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $userId
     *
     * @return User
     */
    public function getById(int $userId): User
    {
        return $this->find($userId);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function save(User $user): void
    {
        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
    }
}
