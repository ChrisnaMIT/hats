<?php

namespace App\DataFixtures;

use App\Entity\Hat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    //Après avoir installer faker avec :
    //composer require --dev orm-fixtures
    //composer require fakerphp/faker

    // ne pas oublier de faire : symfony console doctrine:fixtures:load

    public function load(ObjectManager $manager): void
    {
       $faker = \Faker\Factory::create('en_US');
       for ($i = 0; $i < 10; $i++) {

           $hat = new Hat();
           $hat->setName($faker->name());
           $hat->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 100));
           $manager->persist($hat);

       }







        $manager->flush();
    }
}
