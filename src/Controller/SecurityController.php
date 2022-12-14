<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * login connection
     *
     * @param AuthenticationUtils $AuthenticationUtils
     * @return Response
     */
    #[Route('/connexion', name: 'security.login', methods:['GET','POST'])]
    public function login(AuthenticationUtils $AuthenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $AuthenticationUtils->getLastUsername(),
            'error' => $AuthenticationUtils->getLastAuthenticationError()
        ]);
        return $this->redirectToRoute('admin_car');
    }

    #[Route('/deconnexion', 'security.logout')]
    public function logout()
    {
        //nothing to do here
    }
}
