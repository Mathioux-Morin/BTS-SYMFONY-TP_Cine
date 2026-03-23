<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/movie/crud')]
final class MovieCrudController extends AbstractController
{
    #[Route(name: 'app_movie_crud_index', methods: ['GET'])]
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('movie_crud/index.html.twig', [
            'movies' => $movieRepository->findAll(),
            'tmdb_image_prefix' => $_ENV['TMDB_URL_IMAGE_PREFIX']
        ]);
    }

    #[Route('/new', name: 'app_movie_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->CreateAccessDeniedException('Vous n\'avez pas les droits pour ajouter un film');
        } else {
            $movie = new Movie();
            $form = $this->createForm(MovieType::class, $movie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($movie);
                $entityManager->flush();

                return $this->redirectToRoute('app_movie_crud_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('movie_crud/new.html.twig', [
                'movie' => $movie,
                'form' => $form,
            ]);
        }
    }

    #[Route('/{id}', name: 'app_movie_crud_show', methods: ['GET'])]
    
    public function show(int $id,MovieRepository $movieRepository): Response
    {
        return $this->render('movie_crud/show.html.twig', [
            'movie' => $movieRepository->findOneBy(['idIMDB' => $id]),
            'tmdb_image_prefix' => $_ENV['TMDB_URL_IMAGE_PREFIX']
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movie_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_crud/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

        #[Route('/findBefore/{year}', name:'app_movie_crud_findBefore')]
    public function movieFindBefore(LoggerInterface $logger, MovieRepository $repository, int $year){
        $logger->info("ℹ️ La route findBefore a été appélée");
        return $this->render('movie_crud/index.html.twig',
        [
            'term' => null,
            'movies'=> $repository->findByReleaseBeforeYear($year),
            'tmdb_image_prefix' => $_ENV['TMDB_URL_IMAGE_PREFIX']
        ]);
    }

    #[Route('/{id}', name: 'app_movie_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $movie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_movie_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
