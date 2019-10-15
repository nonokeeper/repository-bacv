<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @var ArticleRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ArticleRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/articles", name="article.index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        $articles = $this->repository->findAll();
        return $this->render('article/index.html.twig', [
            'articles'    => $articles,
            'form'        => $form->createView()
        ]);
    }

    /**
     * @Route("/article/new", name="article.new")
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success','Article créé');
            return $this->redirectToRoute('article.index');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article.edit")
     */
    public function edit(Article $article)
    {
        return $this->render('article/edit.html.twig', [
            'article'    => $article
        ]);
    }

    /**
     * @Route("/article/{slug}/delete", name="article.delete")
     */
    public function delete(Article $article)
    {
        return $this->render('article/delete.html.twig', [
            'article'    => $article
        ]);
    }

}
