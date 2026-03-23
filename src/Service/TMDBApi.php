<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class TMDBApi
{
    private string $TMDBApiKey;
    private string $TMDBToken;
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        // Utilisation de la clé API définie dans le fichier .env
        $apiKey = $_ENV['TMDB_API_KEY'];
        $this->TMDBApiKey = $apiKey;
        $token = $_ENV['TMDB_TOKEN'];
        $this->TMDBToken = $token;
        $this->logger=$logger;

        if (!isset($apiKey)||!isset($token)){
            $this->logger->warning("⚠️ Attention Clé API ou Token vide dans .env");
        }
    }
    /**
     * Recherche de films à partir d'un terme donné (string)
     *
     * @param string $term
     * @return array
     */
    public function search(string $term): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.themoviedb.org/3/search/movie?api_key=' . $this->TMDBApiKey . "&query=" . $term . "&language=fr");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resultat_curl = curl_exec($ch);
        $httpStatut = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        // On transforme le résultat de cURL en un objet JSON utilisable
        $json = json_decode($resultat_curl);
        //var_dump('https://api.themoviedb.org/3/search/movie?api_key=' . $this->themoviedbApiKey ."&query=" . $term);

        if ($error) {
            $this->logger->error("🆘 Erreur curl TMDB : " . $error);
            return [];
        }
        if ($httpStatut >= 200 && $httpStatut < 300) {
            $this->logger->info("ℹ️ récupération des films effectuée avec succès");
            return $json->results;
        } else {
            $this->logger->error("🆘 Échec TMDB ($httpStatut) : " . $resultat_curl);
            return [];
        }
        
        // Renvoi du JSON
    }
    /**
     * Recherche de films à partir d'un identifiant donné (int)
     *
     * @param int $id
     * @return array
     */
    public function searchById(int $id): array
    {
        $endpoint = "https://api.themoviedb.org/3/movie/" . $id . "?language=fr-FR";
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->TMDBToken,
                "accept: application/json"
            ],
        ]);
        $resultat_curl = curl_exec($ch);
        $httpStatut = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        // On transforme le résultat de cURL en un objet JSON utilisable
        $json = json_decode($resultat_curl, true);

        // Gestion des erreurs

        if ($error) {
            $this->logger->error("🆘 Erreur curl TMDB : " . $error);
            return [];
        }

        if ($httpStatut >= 200 && $httpStatut < 300) {
            $this->logger->info("ℹ️ récupération du film avec l'id " . $id . " effectuée avec succès");
            return $json;
        } else {
            $this->logger->error("🆘 Échec TMDB ($httpStatut) : " . $resultat_curl);
            return [];
        }
    }
    public function discover()
    {
        // Endpoint
        $endpoint = "https://api.themoviedb.org/3/discover/movie?include_adult=false&language=fr-FR";
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->TMDBToken,
                "accept: application/json"
            ],
        ]);
        $resultat_curl = curl_exec($ch);
        $error = curl_error($ch);
        $httpStatut = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // On transforme le résultat de cURL en un objet JSON utilisable
        $json = json_decode($resultat_curl);
        
        // Gestion des erreurs

        if ($error) {
            $this->logger->error("🆘 Erreur curl TMDB : " . $error);
            return [];
        }
        if ($httpStatut >= 200 && $httpStatut < 300) {
            $this->logger->info("ℹ️ récupération des films effectuée avec succès");
            return $json->results;
        } else {
            $this->logger->error("🆘 Échec TMDB ($httpStatut) : " . $resultat_curl);
            return [];
        }

    }
}
