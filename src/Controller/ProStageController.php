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

        return $this->render('prostage/entreprises.html.twig', ['listeEntreprises' => $listeEntreprises]);
    }

    /**
     * @Route("/formations", name="liste_des_formations")
     */
    public function indexListeFormations(): Response
    {
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        $listeFormations = $repositoryFormation->findAll();

        return $this->render('prostage/formations.html.twig', ['listeFormations' => $listeFormations]);
    }

    /**
     * @Route("/stages/", name="liste_des_stages")
     */
    public function indexListeStages(): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $listeStages = $repositoryStage->findAll();
       
        return $this->render('prostage/stages.html.twig',['listeStages' => $listeStages]);
    }

    /**
     * @Route("/stages/{id}", name="stage")
     */
    public function indexStages($id=""): Response
    {
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        $listeStages = $repositoryStage->find($id);
        var_dump($id);
        var_dump($listeStages);
       
        return $this->render('prostage/stages2.html.twig',['listeStages' => $listeStages]);
    }

    
}
