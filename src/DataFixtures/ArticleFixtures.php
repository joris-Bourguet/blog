<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\ArticleEntity;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Création de 3 catégorie avec faker

        for ($i=1; $i <= 3; $i++) { 
            $category = new Category();

            $category->setTitle($faker->sentence())
                    ->setDesciption($faker->paragraph());

            $manager->persist($category);


            // Création d'articles random 

            for ($j=1; $j <= mt_rand(4, 10); $j++) { 
                $article = new ArticleEntity();

                $content = join($faker->paragraphs(5));

                $article->setTitle($faker->sentence())
                        ->setContent($content)
                        ->setImage($faker->imageUrl(200, 100))
                        ->setCreatedAt($faker->dateTimeBetween('- 6 months'))
                        ->setCategory($category); 

                $manager->persist($article);       
                
                // Création des commentaires 
                for ($k=1; $k <= mt_rand(6, 10); $k++) { 
                    $comment = new Comment();

                    $content = join($faker->paragraphs(5));
                    $days = (new \DateTime())->diff($article->getCreatedAt())->days;

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days'))
                            ->setArticle($article);

                    $manager->persist($comment);

                }
            }
        }

        $manager->flush();
    }
}
