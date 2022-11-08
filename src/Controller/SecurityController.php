<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        {
            // if ($this->getUser()) {
            //     return $this->redirectToRoute('target_path');
            // }
    
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
    
            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername, 
                'error' => $error
            ]);
        }
    }

    // #[Route(path: '/login_check', name: 'login_check')]
    // public function loginCheck()
    // {
    //     // This code is never executed.
    // }

    #[Route(path: '/logout', name: 'logout')]
    public function logoutCheck()
    {
        // This code is never executed.
    }
}