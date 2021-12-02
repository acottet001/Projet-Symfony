<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProstageController extends AbstractController
{
    /**
     * @Route("/", name="prostage")
     */
    public function index(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Bienvenue sur la page d \' accueil de Prostages',
            'titre'=> 'Bienvenue sur la page d \' accueil de Prostages'
        ]);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function indexEntreprises(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Page des entreprises',
            'titre' => 'Cette page affichera la liste des entreprises proposant un stage'
        ]);
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function indexFormations(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Page de formations',
            'titre' => 'Cette page affichera la liste des formations de l\'IUT',
        ]);
    }

    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function indexStages(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Page de Stages',
            'titre' => 'Cette page affichera le descriptif du stage ayant pour identifiant '
        ]);
    }
}
