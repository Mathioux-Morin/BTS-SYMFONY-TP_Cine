<?php

namespace App\Controller;

use App\Service\Mail;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MailController extends AbstractController
{
    #[Route('/mail', name: 'share_mail')]
    public function shareMail(LoggerInterface $logger ,Request $request, Mail $mail): Response
    {   
        $title = $request->query->get('title');
        $desc = $request->query->get('desc');
        $posterPath = $request->query->get('posterPath');
        $idMovie = $request->query->get('idMovie');
        $logger->info("ℹ️ Le partage par mail a été appelé");

        $mail->shareMail($title, $desc, $posterPath);

        return $this->redirectToRoute(
            'movie_show',
            [
                'idMovie' => $idMovie
            ]
        );
    }
}
