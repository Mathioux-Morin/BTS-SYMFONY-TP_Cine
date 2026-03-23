<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\TMDBApi;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieController extends AbstractController
{
    #[Route('/movies', name: 'movie_list')]
    public function movieList(LoggerInterface $logger, Request $request, TMDBApi $api): Response
    {
        $term = $request->query->get('query');
        $movies = [];
        if (isset($term)){
            $movies=$api->search($term);

        }
        else {
            $movies=$api->discover();
        }

        
        return $this->render(
            'movies/movies_list.html.twig', 
        [
            'movies' => $movies,
            'term' => $term,
            'tmdb_image_prefix' =>$_ENV['TMDB_URL_IMAGE_PREFIX']
        ]);
    }
        #[Route('/save_movie/{idMovie}', name:'app_movie_save')]
    public function save( int $idMovie, EntityManagerInterface $em, MovieRepository $mr, LoggerInterface $logger, TMDBApi $api): Response
    {
        $moviestored= $api->searchById($idMovie);
        if ($mr->findOneBy(['idIMDB' => $moviestored['id']])) {
            $this->addFlash('error','Film déjàa présent dans la bdd');
            return $this->render('movies/movies_show.html.twig', 
        [
            'idMovie' => $idMovie, 
            'movie' => $moviestored,
            'tmdb_image_prefix' => $_ENV['TMDB_URL_IMAGE_PREFIX']
        ]);
        }
        $releaseDate = \DateTime::createFromFormat('Y-m-d', $moviestored['release_date']);
        $movie =new Movie();
        $movie->setTitle($moviestored['title']);
        $movie->setOverview($moviestored['overview']);
        $movie->setReleaseDate($releaseDate);
        $movie->setPosterPath($moviestored['poster_path']);
        $movie->setIdImdb($moviestored['id']);
        $movie->setRuntime($moviestored['runtime']);
        $em->persist($movie);
        $em->flush();
        $this->addFlash('success','Film ajouté avec succès !');
        return $this->render('movies/movies_show.html.twig', 
        [
            'idMovie' => $idMovie, 
            'movie' => $moviestored,
            'tmdb_image_prefix' => $_ENV['TMDB_URL_IMAGE_PREFIX']
        ]);

    }

    #[Route('/movies/{idMovie}', name: 'movie_show')]
    public function movieShow(LoggerInterface $logger, int $idMovie, TMDBApi $api): Response
    {
        $movie=$api->searchById($idMovie);
        return $this->render('movies/movies_show.html.twig', 
        [
            'idMovie' => $idMovie, 
            'movie' => $movie,
            'tmdb_image_prefix' => $_ENV['TMDB_URL_IMAGE_PREFIX']
        ]);
    }
}
