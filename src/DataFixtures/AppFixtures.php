<?php

namespace Fulll\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Fulll\Domain\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $user = new User(1);
         $manager->persist($user);

         $user2 = new User(2);
         $manager->persist($user2);

         $manager->flush();
    }
}
