<?php

namespace App\Controller;

use App\Entity\ArticleEntity;
use App\Entity\Comment;
use App\Form\ArticleFormType;
use App\Form\CommentType;
use App\Repository\ArticleEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleEntityRepository $repo)
    {
        $articles = $repo->findAll();
        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'BlogController',
            'title' => 'Articles - Joris Bourguet',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => 'Accueil - Joris Bourguet',
        ]);
    }

    /**
     * @Route("/blog/new", name="article_create")
     * @Route("/blog/{id<\d+>}/edit", name="article_edit")
     */
    public function form(ArticleEntity $article = null, Request $request)
    {
        if (!$article) {
            $article = new ArticleEntity;
        }
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_details', ['id' => $article->getId()]);
        }

        dump(new \DateTime);

        return $this->render('blog/create.html.twig', [
            'title' => 'Création d\'article - Joris Bourguet',
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null,
        ]);
    }

    /**
     * @Route("/blog/{id<\d+>}", name="article_details")
     */
    public function show_article_details(ArticleEntity $article, Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime)
                    ->setArticle($article);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('article_details', ['id'=> $article->getId()]);
        }
        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView(),
        ]);
    }

}
