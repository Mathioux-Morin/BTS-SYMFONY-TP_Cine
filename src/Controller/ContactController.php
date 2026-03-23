<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_index')]
    public function index(LoggerInterface $logger): Response
    {
        $logger->info(" ℹ️ La route \"/contact\" a été appelée");
        return $this->render('contact/contact_index.html.twig', []);
    }
}
