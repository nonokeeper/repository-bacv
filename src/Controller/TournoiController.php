<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TournoiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TournoiType;
use App\Entity\Tournoi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TournoiController extends AbstractController
{
    /**
     * @var TournoiRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(TournoiRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/tournois", name="tournoi.index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(TournoiType::class);
        $form->handleRequest($request);
        $saison = $_ENV['SAISON'];
        $tournois = $this->repository->findBySaison($saison);

        return $this->render('tournoi/index.html.twig', [
            'tournois'  => $tournois,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/tournoi/new", name="tournoi.new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(TournoiType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Tournoi $tournoi */
            $tournoi = $form->getData();

            // Récupère l'entity manager de Event
            $ec = new EventController();

            // Set des données pour cet événement
            $start = $tournoi->getDateDebut();
            $end = $tournoi->getDateFin();
            $titre = $tournoi->getName();
            $desc = 'Evénement créé par la création du tournoi '.$tournoi->getName();
            $cat = 'Tournoi';
            
            // Appel de la création de l'événement depuis son Controller avec l'EntityManager
            $ec->create($this->em, $start, $end, $titre, $desc, $cat);
            $this->addFlash('success','Evénement créé avec succès !');

            // Sauvegarde du Tournoi puis retour vers la liste des Tournois
            $this->em->persist($tournoi);
            $this->em->flush();
            $this->addFlash('success','Tournoi "'.$tournoi->getName().'" créé avec succès !');
            return $this->redirectToRoute('tournoi.index');
        }

        return $this->render('tournoi/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tournoi/{id}", name="tournoi.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Tournoi $tournoi, Request $request): Response
    {
        $form = $this->createForm(TournoiType::class, $tournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success','Tournoi "'.$tournoi->getName().'" modifié avec succès !');
            return $this->redirectToRoute('tournoi.index');
        }

        return $this->render('tournoi/edit.html.twig', [
            'form'      => $form->createView(),
            'tournoi'   => $tournoi
        ]);
    }

    /**
     * @Route("/tournoiDelete/{id}", name="tournoi.delete", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */

    public function delete(Tournoi $tournoi, Request $request)
    {
        $name = $tournoi->getName();
        $this->em->remove($tournoi);
        $this->em->flush();
        $this->addFlash('success','Tournoi `'.$name.'` supprimé avec succès');
        return $this->redirectToRoute('interclub.index');
    }

}