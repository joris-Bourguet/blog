<?php

namespace App\DataFixtures;

use App\Entity\ArticleEntity;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i < 10; $i++) { 
            $article = new ArticleEntity();
            $article->setTitle("Article Title n:$i")
                    ->setContent("Article contenu n$i")
                    ->setImage('http://placehold.it/350x150')
                    ->setCreatedAt(new \DateTime()); 
            $manager->persist($article);           
        }

        $manager->flush();
    }
}
