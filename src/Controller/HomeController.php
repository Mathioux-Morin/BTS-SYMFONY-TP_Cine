<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(LoggerInterface $logger):Response
    {
        $logger->info(" ℹ️ La route \"/\" a été appelée");
        return $this->render('home/home_index.html.twig', []);
    }
}
