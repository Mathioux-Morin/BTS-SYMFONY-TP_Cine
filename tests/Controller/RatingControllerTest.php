<?php

namespace App\Tests\Controller;

use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RatingControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $ratingRepository;
    private string $path = '/rating/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->ratingRepository = $this->manager->getRepository(Rating::class);

        foreach ($this->ratingRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rating index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'rating[rating]' => 'Testing',
            'rating[createdAt]' => 'Testing',
            'rating[updatedAt]' => 'Testing',
            'rating[idMovieLover]' => 'Testing',
            'rating[idMovie]' => 'Testing',
        ]);

        self::assertResponseRedirects('/rating');

        self::assertSame(1, $this->ratingRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Rating();
        $fixture->setRating('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setIdMovieLover('My Title');
        $fixture->setIdMovie('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Rating');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Rating();
        $fixture->setRating('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setIdMovieLover('Value');
        $fixture->setIdMovie('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'rating[rating]' => 'Something New',
            'rating[createdAt]' => 'Something New',
            'rating[updatedAt]' => 'Something New',
            'rating[idMovieLover]' => 'Something New',
            'rating[idMovie]' => 'Something New',
        ]);

        self::assertResponseRedirects('/rating');

        $fixture = $this->ratingRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getRating());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getIdMovieLover());
        self::assertSame('Something New', $fixture[0]->getIdMovie());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Rating();
        $fixture->setRating('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setIdMovieLover('Value');
        $fixture->setIdMovie('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/rating');
        self::assertSame(0, $this->ratingRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
