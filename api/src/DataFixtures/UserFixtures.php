<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    /** @var UserPasswordHasherInterface $userPasswordHasher */
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = (new User())
            ->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN'])
        ;
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, 'test'));
        $manager->persist($user1);

        $user2 = (new User())
            ->setEmail('director@director.com')
            ->setRoles(['ROLE_DIRECTOR'])
        ;
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, 'test'));
        $manager->persist($user2);

        $manager->flush();
    }
}
