<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, LoggerInterface $logger): Response
        {
            // 1. Si l'utilisateur est déjà connecté (il vient de cliquer sur "Sign in" et Symfony l'a logué)
            $user = $this->getUser();

            if ($user) {
                // 2. On vérifie s'il est admin
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    $logger->warning("Mathieu : ⚠️⚠️⚠️ L'admin " . $user->getUserIdentifier() . " s'est connecté.");
                }

                // Redirige-le vers sa page d'accueil (ex: dashboard)
                return $this->redirectToRoute('movie_list');
            }

            // --- Reste du code classique généré par Symfony ---
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername, 
                'error' => $error
            ]);
        }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
