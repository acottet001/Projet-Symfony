<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="accueil_du_site")
     */
    public function index(): Response
    {
        return $this->render('prostage/index.html.twig', []);
    }

    /**
     * @Route("/entreprises", name="liste_des_entreprises")
     */
    public function indexListeEntreprises(): Response
    {
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $listeEntreprises = $repositoryEntreprise->findAll();

        return $this->render('prostage/listeEntreprises.html.twig', ['listeEntreprises' => $listeEntreprises]);
    }

    /**
     * @Route("/formations", name="liste_des_formations")
     */
    public function indexListeFormations(): Response
    {
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $listeFormations = $repositoryFormation->findAll();

        return $this->render('prostage/listeFormations.html.twig', ['listeFormations' => $listeFormations]);
    }

    /**
     * @Route("/stages/", name="liste_des_stages")
     */
    public function indexListeStages(): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $listeStages = $repositoryStage->findAll();
       
        return $this->render('prostage/listeStages.html.twig',['listeStages' => $listeStages]);
    }

    /**
     * @Route("/stages/{id}", name="stage")
     */
    public function indexStages($id=""): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $stage = $repositoryStage->find($id);
       
        return $this->render('prostage/stage.html.twig',['stage' => $stage]);
    }

    /**
     * @Route("/entreprises/{id}", name="entreprise")
     */
    public function indexEntreprise($id=""): Response
    {
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprise = $repositoryEntreprise->find($id);
       
        return $this->render('prostage/entreprise.html.twig',['entreprise' => $entreprise]);
    }

    /**
     * @Route("/formations/{id}", name="formation")
     */
    public function indexFormation($id=""): Response
    {
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formation = $repositoryFormation->find($id);
       
        return $this->render('prostage/formation.html.twig',['formation' => $formation]);
    }
    
}
