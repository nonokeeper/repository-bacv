<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InterclubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\InterclubType;
use App\Form\InterclubNewType;
use App\Form\InterclubMasculinType;
use App\Form\InterclubNewMasculinType;
use App\Entity\Interclub;
use App\Repository\TeamRepository;
use App\Repository\LieuRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class InterclubController extends AbstractController
{
    /**
     * @var InterclubRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $saison;

    public function __construct(InterclubRepository $repository, EntityManagerInterface $em, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->registry = $registry;
        $this->saison = $_ENV['SAISON'];
    }

    /**
     * @Route("/interclubs", name="interclub.index")
     */
    public function index()
    {
        $interclubs = $this->repository->findAllCurrentSaison($this->saison);

        return $this->render('interclub/index.html.twig', [
            'interclubs'    => $interclubs,
        ]);
    }

    /**
     * @Route("/interclub/compo", name="interclub.compo")
     */
    public function compo()
    {
        $interclubs = $this->repository->findAllForCompo($this->saison);

        return $this->render('interclub/compo.html.twig', [
            'interclubs'    => $interclubs,
        ]);
    }

    /**
     * @Route("/interclub/new", name="interclub.new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(InterclubNewType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Interclub $interclub */
            $interclub = $form->getData();

            // Récupère l'entity manager de Event
            $ec = new EventController();

            // Set des données pour cet événement
            $start = $interclub->getDateRencontre();
            $end = $interclub->getDateRencontre();
            $titre = $interclub->getName();
            $desc = 'Evénement créé par la création de la rencontre '.$interclub->getName();
            $cat = 'Interclub';
            
            // Appel de la création de l'événement depuis son Controller avec l'EntityManager
            $ec->create($this->em, $start, $end, $titre, $desc, $cat);
            $this->addFlash('success','Evénement créé avec succès !');

            // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
            $lieuRepository = new LieuRepository($this->registry);

            if ($interclub->getLocation()) {
                $lieu = $lieuRepository->find($interclub->getLocation());

                // MAJ le lieu à partir de l'id location si non null
                if ($lieu) {
                    $interclub->setLieu($lieu);
                }
            }

            // Sauvegarde de la rencontre Interclub puis retour vers la liste des Interclubs
            $this->em->persist($interclub);
            $this->em->flush();
            $this->addFlash('success','Rencontre "'.$interclub->getName().'" créée avec succès !');
            return $this->redirectToRoute('interclub.index');
        }

        return $this->render('interclub/new.html.twig', [
            'interclubForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/interclub/newMasculin", name="interclub.newMasculin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function newMasculin(Request $request): Response
    {
        $form = $this->createForm(InterclubNewMasculinType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Interclub $interclub */
            $interclub = $form->getData();

            // Récupère l'entity manager de Event
            $ec = new EventController();

            // Set des données pour cet événement
            $start = $interclub->getDateRencontre();
            $end = $interclub->getDateRencontre();
            $titre = $interclub->getName();
            $desc = 'Evénement créé par la création de la rencontre '.$interclub->getName();
            $cat = 'Interclub';
            
            // Appel de la création de l'événement depuis son Controller avec l'EntityManager
            $ec->create($this->em, $start, $end, $titre, $desc, $cat);
            $this->addFlash('success','Evénement créé avec succès !');

            // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
            $lieuRepository = new LieuRepository($this->registry);
            if ($interclub->getLocation()) {
                $lieu = $lieuRepository->find($interclub->getLocation());

                // MAJ le lieu à partir de l'id location si non null
                if ($lieu) {
                    $interclub->setLieu($lieu);
                }
            }

            // Sauvegarde de la rencontre Interclub puis retour vers la liste des Interclubs
            $this->em->persist($interclub);
            $this->em->flush();
            $this->addFlash('success','Rencontre "'.$interclub->getName().'" créée avec succès !');
            return $this->redirectToRoute('interclub.index');
        }

        return $this->render('interclub/newMasculin.html.twig', [
            'interclubForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/interclubDelete/{id}", name="interclub.delete", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */

    public function delete(Interclub $interclub, Request $request)
    {
        $name = $interclub->getName();
        $this->em->remove($interclub);
        $this->em->flush();
        $this->addFlash('success','Rencontre "'.$name.'" supprimée avec succès');
        return $this->redirectToRoute('interclub.index');
    }

    /**
     * @Route("/interclub/{id}", name="interclub.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Interclub $interclub, Request $request, $id): Response
    {
        $form = $this->createForm(InterclubType::class, $interclub);
        $form->handleRequest($request);
        $formMasculin = $this->createForm(InterclubMasculinType::class, $interclub);
        $formMasculin->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
            $lieuRepository = new LieuRepository($this->registry);
            if ($interclub->getLocation()) {
                $lieu = $lieuRepository->find($interclub->getLocation());

                // MAJ le lieu à partir de l'id location si non null
                if ($lieu) {
                    $interclub->setLieu($lieu);
                }
            }

            // Sauvegarde de la rencontre Interclub puis retour vers la liste des Interclubs
            $this->em->flush();
            $this->addFlash('success','Rencontre "'.$interclub->getName().'" modifiée avec succès !');
            
            if ($form->get('saveAndQuit')->isClicked()) {
                return $this->redirectToRoute('interclub.index');
            } else {
                return $this->redirectToRoute('interclub.edit', ['id' => $id]);
            }
            
        }

        if ($formMasculin->isSubmitted() && $formMasculin->isValid())
        {
            // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
            $lieuRepository = new LieuRepository($this->registry);
            if ($interclub->getLocation()) {
                $lieu = $lieuRepository->find($interclub->getLocation());

                // MAJ le lieu à partir de l'id location si non null
                if ($lieu) {
                    $interclub->setLieu($lieu);
                }
            }

            // Sauvegarde de la rencontre Interclub puis retour vers la liste des Interclubs
            $this->em->flush();
            $this->addFlash('success','Rencontre "'.$interclub->getName().'" modifiée avec succès !');
            return $this->redirectToRoute('interclub.index');
        }
        if ($interclub->getTeamHome()) {
            if ($interclub->getTeamHome()->getMixte() == true) {
                return $this->render('interclub/edit.html.twig', [
                    'interclub'     => $interclub,
                    'interclubForm' => $form->createView()
                ]);
            } else {
                return $this->render('interclub/edit_masculin.html.twig', [
                    'interclub'     => $interclub,
                    'interclubForm' => $formMasculin->createView()
                ]);
            }
        } else {
            return $this->render('interclub/edit.html.twig', [
                'interclub'     => $interclub,
                'interclubForm' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/interclubScore", name="interclub.updateScore")
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateScore(Request $request)
    {
        $score = $request->request->get('score');
        $interclubId = $request->request->get('interclub');
        $interclub = $this->repository->find($interclubId);
        $interclub->setScore($score);
        $this->em->flush();
        return $this->redirectToRoute('interclub.index');
    }

    /**
    * @Route("/admin/interclub/teamhome-select", name="interclub_teamhome_select")
    */
    public function getLocationSelect(Request $request)
    {
        $interclub = new Interclub();

        // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
        $teamRepository = new TeamRepository($this->registry);
        $teamhome = $teamRepository->find($request->query->get('teamhome'),null,null);

        // MAJ la donnée teamhome pour l'Interclub
        $interclub->setTeamHome($teamhome);
        $form = $this->createForm(InterclubType::class, $interclub);

        // no location? Return an empty response
        if (!$form->has('location')) {
            return new Response(null, 204);
        }

        return $this->render('admin/interclub/location.html.twig', [
            'interclubForm' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/interclub/newteamhome-select", name="interclub_newteamhome_select")
    */
    public function getNewLocationSelect(Request $request)
    {
        $interclub = new Interclub();

        // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
        $teamRepository = new TeamRepository($this->registry);
        $teamhome = $teamRepository->find($request->query->get('teamhome'),null,null);

        // MAJ la donnée teamhome pour l'Interclub
        $interclub->setTeamHome($teamhome);
        $form = $this->createForm(InterclubNewType::class, $interclub);

        // no location? Return an empty response
        if (!$form->has('location')) {
            return new Response(null, 204);
        }

        return $this->render('admin/interclub/location.html.twig', [
            'interclubForm' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/interclub/masculinteamhome-select", name="interclub_masculinteamhome_select")
    */
    public function getMasculinLocationSelect(Request $request)
    {
        $interclub = new Interclub();

        // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
        $teamRepository = new TeamRepository($this->registry);
        $teamhome = $teamRepository->find($request->query->get('teamhome'),null,null);

        // MAJ la donnée teamhome pour l'Interclub
        $interclub->setTeamHome($teamhome);
        $form = $this->createForm(InterclubNewType::class, $interclub);

        // no location? Return an empty response
        if (!$form->has('location')) {
            return new Response(null, 204);
        }

        return $this->render('admin/interclub/location.html.twig', [
            'interclubForm' => $form->createView(),
        ]);
    }

    /**
    * @Route("/admin/interclub/newmasculinteamhome-select", name="interclub_newmasculinteamhome_select")
    */
    public function getNewMasculinLocationSelect(Request $request)
    {
        $interclub = new Interclub();

        // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
        $teamRepository = new TeamRepository($this->registry);
        $teamhome = $teamRepository->find($request->query->get('teamhome'),null,null);

        // MAJ la donnée teamhome pour l'Interclub
        $interclub->setTeamHome($teamhome);
        $form = $this->createForm(InterclubNewMasculinType::class, $interclub);

        // no location? Return an empty response
        if (!$form->has('location')) {
            return new Response(null, 204);
        }

        return $this->render('admin/interclub/location.html.twig', [
            'interclubForm' => $form->createView(),
        ]);
    }
}
