<?php

namespace App\DataFixtures;

use App\Entity\Plant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i <100; $i++){
            $plant = new Plant();
         /*   $plant ->setTitle($faker->words(3,true))
                   ->setDescription($faker->sentences(3,true))
                   ->setMaladie($faker->sentences(3,true));
            $manager->persist($plant);*/
        }
       // $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

       // $manager->flush();
    }
}
