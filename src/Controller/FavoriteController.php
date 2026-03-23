<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FavoriteController extends AbstractController
{
    #[Route('/favorites', name: 'favorites_list')]
    public function index(LoggerInterface $logger): Response
    {
        $logger->info(" ℹ️ La route \"/favorites\" a été appelée");
        return $this->render('favorites/favorites_list.html.twig', []);
    }
}
