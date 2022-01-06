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
        $faker = \Faker\Factory::create('fr_FR');

        $stage = new Stage();
        $entreprise = new Entreprise();
        $formation = new Formation();

        $entreprise->setNom($faker->company);
        echo "test:";
        var_dump($faker->jobTitle);
        //Faker->bs ne renvoient rien
        $entreprise->setActivite($faker->catchPhrase);
        $entreprise->setAdresse($faker->address);

        // A completer par moi
        $formation->setNomLong("DUT Informatique");
        $formation->setNomCourt("DUT Infor");

        $stage->setTitre($faker->jobTitle);
        $stage->setDomaine($faker->catchPhrase);
        $stage->setEmail($faker->email);
        $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));


        $entreprise->addStage($stage);
        $formation->addStage($stage);
        $stage->addFormation($formation);
       
        $manager->persist($formation);
        $manager->persist($entreprise);
        $manager->persist($stage);

        $manager->flush();
    }
}
