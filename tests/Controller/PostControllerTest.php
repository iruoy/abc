<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        self::createClient();

        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
    }

    public function testPostIndex(): void
    {
        $client = static::getClient();
        $client->request('GET', 'post');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Posts');
    }

    public function testPostShow(): void
    {
        $post = $this->entityManager
            ->getRepository(Post::class)
            ->find(1);

        $client = static::getClient();
        $client->request('GET', 'post/1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', $post->getTitle());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
