<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 5 clients
        for ($i = 0; $i < 5; $i++) {
            $customer = new Customer();
            $customer->setFirstName('John');
            $customer->setLastName('Doe');
            // phone
            $customer->setPhone('0123456789');
            // address
            $customer->setAddress('1 rue de la paix');
            $manager->persist($customer);
        }
        $manager->flush();

    }
}
