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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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

    private function getFileName(?UploadedFile $imageFile)
    {
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            // Move the file to the directory where images are stored
            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            return $newFilename;
        } else {
            return null;
        }
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
            /** Récupère les noms de fichiers téléversés et MAJ de l'article si non null */
            $newFilename = $this->getFileName($form['Image']->getData());
            if ($newFilename) { $article->setImageFilename($newFilename); }
            $newFilename2 = $this->getFileName($form['Image2']->getData());
            if ($newFilename2) { $article->setImage2Filename($newFilename2); }
            $title = $form->get('title')->getData();

            if (!$title)
            {
                $this->addFlash('error','Merci de saisir un titre pour cet article');
                return $this->render('article/new.html.twig', [
                    'form' => $form->createView()
                ]);
            }
            
            $article->setPublicationDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $article->setLastUpdateDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $article->setAuteur($this->getUser());
            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success','Article "'.$article->getTitle().'" bien créé !');
            return $this->redirectToRoute('article.index');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error','Merci de fournir des images au format jpg/gif/jpeg/png');
                return $this->render('article/new.html.twig', [
                    'form' => $form->createView()
                ]);
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
            /** Récupère les noms de fichiers téléversés et MAJ de l'article si non null */
            $newFilename = $this->getFileName($form['Image']->getData());
            if ($newFilename) { $article->setImageFilename($newFilename); }
            $newFilename2 = $this->getFileName($form['Image2']->getData());
            if ($newFilename2) { $article->setImage2Filename($newFilename2); }

            $article->setLastUpdateDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $this->em->flush();
            $this->addFlash('success','Article "'.$article->getTitle().'" modifié avec succès !');
            return $this->redirectToRoute('article.index');
        }
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error','Merci de fournir des images au format jpg/gif/jpeg/png');
                return $this->render('article/edit.html.twig', [
                    'article'   => $article,
                    'form' => $form->createView()
                ]);
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