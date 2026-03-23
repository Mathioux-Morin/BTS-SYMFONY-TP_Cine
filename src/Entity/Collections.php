<?php

namespace App\Entity;

use App\Repository\CollectionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionsRepository::class)]
class Collections
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, MovieLover>
     */
    #[ORM\ManyToMany(targetEntity: MovieLover::class, mappedBy: 'Collections')]
    private Collection $movieLovers;

    #[ORM\Column]
    private ?int $creator = null;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\ManyToMany(targetEntity: Movie::class, inversedBy: 'collections')]
    private Collection $movies;

    public function __construct()
    {
        $this->movieLovers = new ArrayCollection();
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, MovieLover>
     */
    public function getMovieLovers(): Collection
    {
        return $this->movieLovers;
    }

    public function addMovieLover(MovieLover $movieLover): static
    {
        if (!$this->movieLovers->contains($movieLover)) {
            $this->movieLovers->add($movieLover);
            $movieLover->addCollection($this);
        }

        return $this;
    }

    public function removeMovieLover(MovieLover $movieLover): static
    {
        if ($this->movieLovers->removeElement($movieLover)) {
            $movieLover->removeCollection($this);
        }

        return $this;
    }

    public function getCreator(): ?int
    {
        return $this->creator;
    }

    public function setCreator(int $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        $this->movies->removeElement($movie);

        return $this;
    }
}
