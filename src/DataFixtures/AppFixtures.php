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
        // var_dump($faker->catchPhrase);
        //Faker->bs et ->catchPhrase ne renvoient rien
        $entreprise->setActivite("Informatique");
        $entreprise->setAdresse($faker->address);

        $formation->setNomLong("DUT Informatique");
        $formation->setNomCourt("DUT Infor");

        $stage->setTitre($faker->jobTitle);
        $stage->setDomaine($faker->);
        $stage->setEmail($faker->email);

        $stage->setEntrepriseId($faker->);
        $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));


        $manager->persist($formation);
        $manager->persist($entreprise);

        $manager->flush();
    }
}
