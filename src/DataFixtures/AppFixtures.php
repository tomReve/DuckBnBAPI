<?php

namespace App\DataFixtures;

use App\Entity\Housing;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $user = new User();
        $user->setPseudo('Poulet braisé')
             ->setPassword("toto")
             ->setEmail("toto@gmail.com")
             ->setCreatedAt(new \DateTime());

        $manager->persist($user);

        for ($i = 0; $i < 20; $i++) {
            $housing = new Housing();
            $path = 'assets/images/maison.jpg';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $imageEncode = "data:image/".$type.";base64,".base64_encode($data);
            $housing->setTitle($faker->streetName)
                    ->setDescription($faker->text)
                    ->setPrice($faker->numberBetween(10,200))
                    ->setAddress($faker->address)
                    ->setNbBed($faker->numberBetween(1,4))
                    ->setNbRoom($faker->numberBetween(1,4))
                    ->setNbTravelerMax($faker->numberBetween(1,4))
                    ->setPicture($imageEncode);
            $manager->persist($housing);
        }

        $manager->flush();
    }
}
