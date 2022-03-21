<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/signin", name="prostage_inscription")
     */
    public function ajoutUtilisateur(Request $requeteHTTP,EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $unUtilisateur = new User();
        $formulaireUtilisateur = $this->createForm(UserType::class, $unUtilisateur);
    
        $formulaireUtilisateur->handleRequest($requeteHTTP);

        if($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
        {
            $unUtilisateur->setRoles(["ROLE_USER"]);
            $motDePasseEncoder = $encoder->encodePassword($unUtilisateur, $unUtilisateur->getPassword());
            $unUtilisateur->setPassword($motDePasseEncoder);

            $manager->persist($unUtilisateur);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }

        $vueFormulaireUtilisateur = $formulaireUtilisateur->createView();
        // Envoyer la formation récupérée, à la vue chargée de l'afficher
        return $this->render('security/signin.html.twig',['vueFormulaireUtilisateur' => $vueFormulaireUtilisateur]);
    }
}
