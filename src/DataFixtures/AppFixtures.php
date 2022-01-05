<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $stage = new Stage();
        $entreprise = new Entreprise();
        $formation = new Formation();

        $formation->setNomLong("DUT Informatique");
        $formation->setNomCourt("DUT Infor");
        $manager->persist($formation);

        $manager->flush();
    }
}
