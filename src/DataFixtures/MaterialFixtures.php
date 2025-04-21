<?php

namespace App\DataFixtures;

use App\Entity\Material;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MaterialFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $materials = ['Coton', 'Laine', 'Cuir', 'Soie', 'Jean'];

        foreach ($materials as $name) {
            $material = new MaterialFixtures();
            $material->setName($name);
            $manager->persist($material);
        }

        $manager->flush();
    }
}

