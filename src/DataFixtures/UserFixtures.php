<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; ++$i) {
            $user = new User();
            $user
                ->setEmail('user'.$i.'@dummymail.com')
                ->setPassword('somePassword')
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
