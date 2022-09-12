<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // create 10 random ingredients coherent with Pizza
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setName($faker->name);
            $manager->persist($ingredient);
        }
        $manager->flush();
    }
}
