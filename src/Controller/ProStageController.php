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
    public function afficherListeStages(StageRepository $repositoryStage): Response
    {
        // Récupérer tous les stages enregistrés en BD
        $listeStages = $repositoryStage->findAll();

       // Envoyer les stages récupérées à la vue chargée de l'afficher
        return $this->render('prostage/listeStages.html.twig',['listeStages' => $listeStages]);
    }

    /**
     * @Route("/stages/{id}", name="prostage_detail_stage_par_id")
     */
    public function afficherDetailStage(Stage $stage): Response
    {
        // Envoyer le stage récupérée à la vue chargée de l'afficher
        return $this->render('prostage/detailStage.html.twig',['stage' => $stage]);
    }

    /**
     * @Route("/entreprises/{id}", name="prostage_detail_entreprise_par_id")
     */
    public function afficherDetailEntreprise(Entreprise $entreprise): Response
    {
        // Envoyer l'entreprise récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/detailEntreprise.html.twig',['entreprise' => $entreprise]);
    }

    /**
     * @Route("/formations/{id}", name="prostage_detail_formation_par_id")
     */
    public function afficherDetailFormation(Formation $formation): Response
    {
        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('prostage/detailFormation.html.twig',['formation' => $formation]);
    }
    
}
