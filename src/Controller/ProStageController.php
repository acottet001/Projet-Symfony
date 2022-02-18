<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Repository\StageRepository;

use App\Form\EntrepriseType;
use App\Form\StageType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="prostage_accueil_du_site")
     */
    public function index(): Response
    {
        return $this->render('prostage/index.html.twig', []);
    }

    /**
     * @Route("/entreprises", name="prostage_liste_des_entreprises")
     */
    // Récupération du repository des formations grâce à l'injection 
    // de la dépendance de EntrepriseRepository
    public function afficherListeEntreprises(EntrepriseRepository $repositoryEntreprise): Response
    {
        // Récupérer toutes les entreprises enregistrées en BD
        $listeEntreprises = $repositoryEntreprise->findAll();

        // Envoyer les entreprises récupérées à la vue chargée de l'afficher
        return $this->render('prostage/listeEntreprises.html.twig', ['listeEntreprises' => $listeEntreprises]);
    }

    /**
     * @Route("/formations", name="prostage_liste_des_formations")
     */
    // Récupération du repository des formations grâce à l'injection 
    // de la dépendance de FormationRepository
    public function afficherListeFormations(FormationRepository $repositoryFormation): Response
    {
        // Récupérer toutes les formations enregistrées en BD
        $listeFormations = $repositoryFormation->findAll();

        // Envoyer les formations récupérées à la vue chargée de l'afficher
        return $this->render('prostage/listeFormations.html.twig', ['listeFormations' => $listeFormations]);
    }

    /**
     * @Route("/stages/", name="prostage_liste_des_stages")
     */
    // Récupération du repository des stages grâce à l'injection
    // de la dépendance de StageRepository
    public function afficherListeStages(StageRepository $repositoryStage): Response
    {
        // Récupérer tous les stages enregistrés en BD
        $listeStages = $repositoryStage->recupererStageAvecSonEntrepriseQB();

       // Envoyer les stages récupérées à la vue chargée de l'afficher
        return $this->render('prostage/listeStages.html.twig',['listeStages' => $listeStages]);
    }

    /**
     * @Route("/stages/{id}", name="prostage_detail_stage_par_id")
     */
    // Récupération du stage grâce à l'injection 
    // de la dépendance de Stage et l'id de la route
    public function afficherDetailStage(Stage $stage): Response
    {
        // Envoyer le stage récupérée à la vue chargée de l'afficher
        return $this->render('prostage/detailStage.html.twig',['stage' => $stage]);
    }

    /**
     * @Route("/entreprises/{id}", name="prostage_detail_entreprise_par_id")
     */
    // Récupération de l'entreprise grâce à l'injection 
    // de la dépendance de l'Entreprise et l'id de la route
    public function afficherDetailEntreprise(Entreprise $entreprise): Response
    {
        // Envoyer l'entreprise récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/detailEntreprise.html.twig',['entreprise' => $entreprise]);
    }

    /**
     * @Route("/formations/{id}", name="prostage_detail_formation_par_id")
     */
    // Récupération de la formation grâce à l'injection 
    // de la dépendance de la Formation et l'id de la route
    public function afficherDetailFormation(Formation $formation): Response
    {
        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/detailFormation.html.twig',['formation' => $formation]);
    }
    

    /**
     * @Route("/stagesParFormationDQL/{nomCourt}", name="prostageListeStagesParNomCourtFormation_DQL")
     */
    // Récupération de la formation grâce à l'injection 
    // de la dépendance de la Formation et l'id de la route
    public function listeStageParNomCourtFormation(StageRepository $repositoryStage, $nomCourt): Response
    {
        
        $listeStages = $repositoryStage->findByFormationDQL($nomCourt);

        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/listeStages.html.twig',['listeStages' => $listeStages]);
    }

    /**
     * @Route("/stagesParEntrepriseQB/{nom}", name="prostageListeStagesParNomEntreprise_QB")
     */
    // Récupération de la formation grâce à l'injection 
    // de la dépendance de la Formation et l'id de la route
    public function listeStageParNomEntrepriseQB(StageRepository $repositoryStage, $nom): Response
    {
        
        $listeStages = $repositoryStage->findByEntrepriseQueryBuilder($nom);

        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/listeStages.html.twig',['listeStages' => $listeStages]);
    }

    /**
     * @Route("/ajouter/entreprise", name="prostage_ajouterUneEntreprise")
     */
    public function ajouterUneEntreprise(Request $requeteHTTP,EntityManagerInterface $manager): Response
    {
        $uneEntreprise = new Entreprise();
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $uneEntreprise);
    
        $formulaireEntreprise->handleRequest($requeteHTTP);
        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {
            $manager->persist($uneEntreprise);
            $manager->flush();

            return $this->redirectToRoute('prostage_detail_entreprise_par_id',['id' =>$uneEntreprise->getId()]);
        }

        $vueFormulaireEntreprise = $formulaireEntreprise->createView();

        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/ajoutEntreprise.html.twig',['vueFormulaireEntreprise' => $vueFormulaireEntreprise]);
    }


    
    /**
     * @Route("/modifier/entreprise/{nomEntreprise}", name="prostage_modifierUneEntreprise_parNom")
     */
    public function modifierUneEntreprise(EntrepriseRepository $repositoryEntreprise,Request $requeteHTTP,EntityManagerInterface $manager,$nomEntreprise): Response
    {
        $uneEntreprise = $repositoryEntreprise->findOneBy(['nom' => $nomEntreprise]);
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $uneEntreprise);
        
        $formulaireEntreprise->handleRequest($requeteHTTP);
        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {
            $manager->persist($uneEntreprise);
            $manager->flush();

            return $this->redirectToRoute('prostage_detail_entreprise_par_id',['id' =>$uneEntreprise->getId()]);
        }

        $vueFormulaireEntreprise = $formulaireEntreprise->createView();

        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/ajoutEntreprise.html.twig',['vueFormulaireEntreprise' => $vueFormulaireEntreprise]);
    }

    /**
     * @Route("/ajouter/stage", name="prostage_ajouterUnStage")
     */
    public function ajouterUnStage(Request $requeteHTTP,EntityManagerInterface $manager): Response
    {
        $unStage = new Stage();
        $formulaireStage = $this->createForm(StageType::class, $unStage);
    
        $formulaireStage->handleRequest($requeteHTTP);
        if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
        {
            $manager->persist($unStage);
            $manager->persist($unStage->getEntreprise());
            $manager->flush();

            return $this->redirectToRoute('prostage_detail_stage_par_id',['id' =>$unStage->getId()]);
        }

        $vueFormulaireStage = $formulaireStage->createView();

        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/ajoutStage.html.twig',['vueFormulaireStage' => $vueFormulaireStage]);
    }
}
