<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class Webhook
{
    private string $webhookURL;
    private LoggerInterface $logger;
    private string $tmdb_image_prefix;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->webhookURL = $_ENV['WEBHOOK_URL'];
        $this->tmdb_image_prefix = $_ENV['TMDB_URL_IMAGE_PREFIX'];

        if (empty($this->webhookURL)||empty($this->tmdb_image_prefix)){
            $logger->warning("⚠️ Attention Url Webhook ou Prefixe url des images manquant dans le .env");
        }
    }

    public function shareDiscord($title, $desc, $posterPath): bool
    {
        if (empty($this->webhookURL)) {
            $this->logger->error('🆘 Webhook URL manquante dans le .env');
            return false;
        }

        $data = [
            "embeds" => [
                [
                    "title" => $title,
                    "description" => $desc,
                    "color" => 9896707,
                    "image" => [
                        "url" => $this->tmdb_image_prefix . $posterPath
                    ]
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->webhookURL,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        $resultat_curl = curl_exec($ch);
        $httpStatut = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        if ($error) {
            $this->logger->error("🆘 Erreur curl Discord : " . $error);
            return false;
        }
        if ($httpStatut >= 200 && $httpStatut < 300) {
            $this->logger->info("ℹ️ Message Discord envoyé avec succès !");
            return true;
        } else {
            $this->logger->error("🆘 Échec Discord ($httpStatut) : " . $resultat_curl);
            return false;
        }
    }
}