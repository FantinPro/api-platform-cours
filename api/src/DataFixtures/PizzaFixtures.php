<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Pizza;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PizzaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
       $faker = \Faker\Factory::create();
       $ingredients = $manager->getRepository(Ingredient::class)->findAll();

       for ($i = 0; $i < 10; $i++) {
           $pizza = new Pizza();
           $pizza->setName($faker->name);
           $pizza->setDescription($faker->text);
           for($j = 0; $j < 3; $j++) {
               $pizza->addIngredient($faker->randomElement($ingredients));
           }
           $manager->persist($pizza);
       }

         $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            IngredientFixtures::class,
        ];
    }
}
