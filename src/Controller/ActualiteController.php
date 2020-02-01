<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actualite;
use Symfony\Component\Security\Core\Security;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ActualiteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ActualiteController extends AbstractController
{
    /**
     * @var ActualiteRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ActualiteRepository $repository, EntityManagerInterface $em, Security $security)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * @Route("/actualite", name="actualite.index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ActualiteType::class);
        $form->handleRequest($request);

        $actualites = $this->repository->findAll();
        return $this->render('actualite/index.html.twig', [
            'actualites'    => $actualites,
            'form'        => $form->createView()
        ]);
    }

    /**
     * @Route("/actualite/new", name="actualite.new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request)
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($actualite);
            $this->em->flush();
            $this->addFlash('success','actualite "'.$actualite->getName().'" bien créée !');
            return $this->redirectToRoute('actualite.index');
        }

        return $this->render('actualite/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/actualite/{slug}", name="actualite.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Actualite $actualite, Request $request)
    {
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success','actualite "'.$actualite->getName().'" modifiée avec succès !');
            return $this->redirectToRoute('actualite.index');
        }

        return $this->render('actualite/edit.html.twig', [
            'actualite'   => $actualite,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/actualite/{slug}/delete", name="actualite.delete", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(actualite $actualite, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getSlug(), $request->get('_token')))
        {
            $name = $actualite->getName();
            $this->em->remove($actualite);
            $this->em->flush();
            $this->addFlash('success','actualite "'.$name.'" supprimée avec succès');
        }
        return $this->redirectToRoute('actualite.index');
    }

}
