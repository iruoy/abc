<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $body = '';
            for ($j = 0; $j < rand(3, 7); $j++) {
                $paragraph = $faker->sentences(rand(1, 10), true);
                $body .= "<p>$paragraph</p>\n";
            }

            $post = new Post();
            $post->setTitle($faker->sentence());
            $post->setBody($body);
            $manager->persist($post);
        }

        $manager->flush();
    }
}
