<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;

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
        $this->article = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/articles", name="article.index")
     */
    public function index()
    {
        return $this->render('article/index.html.twig');
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
            'controller_name' => 'ArticleController',
        ]);
    }

}
