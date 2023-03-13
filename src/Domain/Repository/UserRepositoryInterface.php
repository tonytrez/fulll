<?php

namespace Fulll\Domain\Repository;

use Fulll\Domain\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param int $userId
     *
     * @return User
     */
    public function getById(int $userId): User;

    /**
     * @param User $user
     *
     * @return void
     */
    public function save(User $user): void;
}
