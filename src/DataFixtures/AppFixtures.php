<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // Création utilisateurs 
        $andreas = new User();
        $andreas->setPrenom("Andréas");
        $andreas->setNom("Cottet");
        $andreas->setEmail("andrecot2502@gmail.com");
        $andreas->setRoles(['ROLE_ADMIN','ROLE_USER']);
        $andreas->setPassword("$2y$10$94ZkphrHfWLBToG07jZ14OBuXas9hyEkJbVw2vBziJ3bwPxSTdjWG");
        $manager->persist($andreas);

        $utilisateurPasOuf = new User();
        $utilisateurPasOuf->setPrenom("Utilisateur");
        $utilisateurPasOuf->setNom("PasOuf");
        $utilisateurPasOuf->setEmail("utilisateurPasOuf@gmail.com");
        $utilisateurPasOuf->setRoles(['ROLE_USER']);
        $utilisateurPasOuf->setPassword('$2y$10$mM.Sd0Wh2ZIv/p61FRSQLOuPzFjR/4M8nJd1ywkosMaJmWg5ubve6');
        $manager->persist($utilisateurPasOuf);

        // Variable contenant le générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR');

        // La liste de toutes les entreprises générées
        $listeEntreprises = array();

        // La liste de toutes les formations générées
        $listeFormations = array();

        // Nombre d'entreprise à générer
        $nbEntreprises = 10;

        // Nombre de stages à générer
        $nbStages = 10;

        // Liste d'activités possible d'une entreprise
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
    
        // Liste des formations [Nom Court,Nom Long]
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

        // Ajout de toutes les formations dans Doctrine
        foreach($nomFormationsDisponibles as $nomFormationDisponible)
        {
            // On crée une nouvelle formation
            $formation = new Formation();

            // On lui set son nomCourt puis son nomLong
            $formation->setNomCourt($nomFormationDisponible[0]);
            $formation->setNomLong($nomFormationDisponible[1]);

            // On ajoute la formation dans les données dans Doctrine
            $manager->persist($formation);

            // On ajoute la formation dans la liste de toutes les formations
            $listeFormations[] = $formation;
        }

        // Ajout de nombre d'entreprises dans les données
        for($i = 0; $i < $nbEntreprises; $i++)
        {
            //Faker->bs ne renvoient rien

            // On crée une nouvelle entreprise
            $entreprise = new Entreprise();

            // On lui set son nom, son actvité, son adresse
            $entreprise->setNom($faker->company);
            $entreprise->setActivite($faker->randomElement($activiteEntrepriseDisponibles));
            $entreprise->setAdresse($faker->address);

            $entreprise->setUrlSiteWeb($faker->url);
            
            // On ajoute la formation dans les données dans Doctrine
            $manager->persist($entreprise);

            // On ajoute la formation dans la liste de toutes les formations
            $listeEntreprises[] = $entreprise;
        }

        for($i = 0; $i < $nbStages; $i++)
        {
            // On crée une nouvelle entreprise
            $stage = new Stage();

            // On lui set un titre de travail, un domaine(une activite)
            // un email, une description et une entreprise et des formations
            $stage->setTitre($faker->jobTitle);
            $stage->setDomaine($faker->randomElement($activiteEntrepriseDisponibles));
            $stage->setEmail($faker->email);
            $stage->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));

            $stageEntreprise = $faker->randomElement($listeEntreprises);
            
            // On ajoute le stage à l'entreprise
            $stageEntreprise->addStage($stage);

            // On modifie l'entreprise dans les données dans Doctrine
            $manager->persist($stageEntreprise);

            //
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
