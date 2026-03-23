<?php

namespace App\Tests\Controller;

use App\Entity\Collections;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CollectionsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $collectionRepository;
    private string $path = '/collections/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->collectionRepository = $this->manager->getRepository(Collections::class);

        foreach ($this->collectionRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Collection index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'collection[name]' => 'Testing',
            'collection[movies]' => 'Testing',
            'collection[creator]' => 'Testing',
            'collection[movieLovers]' => 'Testing',
        ]);

        self::assertResponseRedirects('/collections');

        self::assertSame(1, $this->collectionRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Collections();
        $fixture->setName('My Title');
        $fixture->setMovies('My Title');
        $fixture->setCreator('My Title');
        $fixture->setMovieLovers('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Collection');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Collections();
        $fixture->setName('Value');
        $fixture->setMovies('Value');
        $fixture->setCreator('Value');
        $fixture->setMovieLovers('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'collection[name]' => 'Something New',
            'collection[movies]' => 'Something New',
            'collection[creator]' => 'Something New',
            'collection[movieLovers]' => 'Something New',
        ]);

        self::assertResponseRedirects('/collections');

        $fixture = $this->collectionRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getMovies());
        self::assertSame('Something New', $fixture[0]->getCreator());
        self::assertSame('Something New', $fixture[0]->getMovieLovers());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Collections();
        $fixture->setName('Value');
        $fixture->setMovies('Value');
        $fixture->setCreator('Value');
        $fixture->setMovieLovers('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/collections');
        self::assertSame(0, $this->collectionRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
