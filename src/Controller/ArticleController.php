<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticleController extends AbstractController
{

    /**
     * @var ArticleRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ArticleRepository $repository, EntityManagerInterface $em, Security $security)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->security = $security;
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $title = $form->get('title')->getData();
            if (!$title)
            {
                $this->addFlash('error','Merci de saisir un titre pour cet article');
                return $this->render('article/new.html.twig', [
                    'form' => $form->createView()
                ]);
            }
            
            $article->setPublicationDate(new \DateTime('now'));
            $article->setLastUpdateDate(new \DateTime('now'));
            $article->setAuteur($this->getUser());
            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success','Article "'.$article->getTitle().'" bien créé !');
            return $this->redirectToRoute('article.index');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Article $article, Request $request)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $article->setLastUpdateDate(new \DateTime('now'));
            $this->em->flush();
            $this->addFlash('success','Article "'.$article->getTitle().'" modifié avec succès !');
            return $this->redirectToRoute('article.index');
        }

        return $this->render('article/edit.html.twig', [
            'article'   => $article,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{slug}/delete", name="article.delete", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Article $article, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$article->getSlug(), $request->get('_token')))
        {
            $title = $article->getTitle();
            $this->em->remove($article);
            $this->em->flush();
            $this->addFlash('success','Article "'.$title.'" supprimé avec succès');
        }
        return $this->redirectToRoute('article.index');
    }
    
    protected function getUser() : User
    {
        $user = $this->security->getUser();
        return $user;
    }

}