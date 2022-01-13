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

        $listeEntreprises = array();
        $listeFormations = array();
        $nbEntreprises = 10;
        $listeEntreprises = array();
        $nbStages = 10;

        $activiteEntrepriseDisponibles = array(
            "Logistique",
            "Commerçant",
            "Informatique",
            "Agriculture",
            "Transport",
            "Services",
            "Sante",
            "Economique",
            "Autres"
        );
    
        $nomFormationsDisponibles = [
            ["DUT Tech de CO" , "DUT Techniques de Commercialisation"],
            ["Licence Pro COM Agrodistri et Agroali" , "Licence Professionnelle Commercialisation Agrodistribution et Agroalimentaire "],
            ["BUT Tech de CO", "Bachelor Universitaire Technologique Techniques de Commercialisation"],
            ["LP Evénementiel","Licence Professionnelle Evenementiel"],
            ["LP Métiers du Num", "Licence Professionnelle Métiers du numérique"],
            ["BUT Génie Industriel et Maintenance","Bachelor Universitaire Technologique Génie Industriel et Maintenance"],
            ["DUT GEA" ,"Diplôme Universaire Technologique Gestion des Entreprises et des Administrations"],
            ["LP Prog Avancée","Licence Professionnelle Programmation Avancée "],
            ["LP Eco","Licence Professionnelle Economie"]
        ];

        foreach($nomFormationsDisponibles as $nomFormationDisponible)
        {
            $formation = new Formation();
            $formation->setNomCourt($nomFormationDisponible[0]);
            $formation->setNomLong($nomFormationDisponible[1]);
            $manager->persist($formation);
            $listeFormations[] = $formation;
        }


        for($i = 0; $i < $nbEntreprises; $i++)
        {
            //Faker->bs ne renvoient rien
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $numActivite = $faker->numberBetween(0,8);
            $entreprise->setActivite($faker->randomElement($activiteEntrepriseDisponibles));
            $entreprise->setAdresse($faker->address);
            //$entreprise->setUrlSiteWeb($faker->url);
            $manager->persist($entreprise);
            $listeEntreprises[] = $entreprise;
        }

        for($i = 0; $i < $nbStages; $i++)
        {
            $stage = new Stage();
            $stage->setTitre($faker->jobTitle);
            $stage->setDomaine($faker->randomElement($activiteEntrepriseDisponibles));
            $stage->setEmail($faker->email);
            $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));

            $stageEntreprise = $faker->randomElement($listeEntreprises);
            
            $stageEntreprise->addStage($stage);
            $manager->persist($stageEntreprise);

            $nbrFormations = $faker->numberBetween(0,2);

            foreach($faker->randomElements($listeFormations, $nbrFormations + 1) as $formation)
            {
                $stage->addFormation($formation);
                $manager->persist($formation);
            }
            
            $manager->persist($stage);
        }

        $manager->flush();

        
    }
}
