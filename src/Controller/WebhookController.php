<?php

namespace App\Controller;

use App\Service\Webhook;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WebhookController extends AbstractController
{
    #[Route('/share', name: 'share_discord')]
    public function shareDiscord(LoggerInterface $logger ,Request $request, Webhook $webhook): Response
    {   
        $title = $request->query->get('title');
        $desc = $request->query->get('desc');
        $posterPath = $request->query->get('posterPath');
        $idMovie = $request->query->get('idMovie');
        $logger->info("ℹ️ Le webhook a été appelé");

        $webhook->shareDiscord($title, $desc, $posterPath);

        return $this->redirectToRoute(
            'movie_show',
            [
                'idMovie' => $idMovie
            ]
        );
    }
}
