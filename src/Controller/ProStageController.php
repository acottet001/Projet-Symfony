<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="prostage")
     */
    public function index(): Response
    {
        return $this->render('prostage/index.html.twig', []);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function indexEntreprises(): Response
    {
        return $this->render('prostage/entreprises.html.twig', [ ]);
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function indexFormations(): Response
    {
        return $this->render('prostage/formations.html.twig', []);
    }

    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function indexStages($id=""): Response
    {
        return $this->render('prostage/stages.html.twig', 
        ['idStage' => $id]);
    }
}
