<?php

namespace App\DataFixtures;

use App\Entity\Housing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $housing = new Housing();
            $housing->setTitle($faker->streetName)
                    ->setDescription($faker->text)
                    ->setPrice($faker->numberBetween(10,200))
                    ->setAddress($faker->address)
                    ->setNbBed($faker->numberBetween(1,4))
                    ->setNbRoom($faker->numberBetween(1,4))
                    ->setNbTravelerMax($faker->numberBetween(1,4))
                    ->setPicture(base64_encode('assets/images/olivier.jpg'));
            $manager->persist($housing);
        }

        $manager->flush();
    }
}