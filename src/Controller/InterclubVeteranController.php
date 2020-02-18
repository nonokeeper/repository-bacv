<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\InterclubVeteranRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\InterclubVeteranType;
use App\Entity\InterclubVeteran;
use App\Repository\TeamVeteranRepository;
use App\Repository\LieuRepository;
use App\Entity\Lieu;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class InterclubVeteranController extends AbstractController
{
    /**
     * @var InterclubVeteranRepository
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

    public function __construct(InterclubVeteranRepository $repository, EntityManagerInterface $em, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->registry = $registry;
        $this->saison = $_ENV['SAISON'];
    }

    /**
     * @Route("/interclubveteran", name="interclubVeteran.index")
     */
    public function index(Request $request): Response
    {        
        $interclubsVeteran = $this->repository->findAllCurrentSaison($this->saison);

        return $this->render('interclub_veteran/index.html.twig', [
            'interclubsVeteran' => $interclubsVeteran,
        ]);
    }

    /**
     * @Route("/interclubveteran/new", name="interclubVeteran.new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(InterclubVeteranType::class);
        $form->handleRequest($request);
        $lieu = null;

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var InterclubVeteran $interclubsVeteran */
            $interclubsVeteran = $form->getData();

            // Récupère l'entity manager de Event
            $ec = new EventController();

            // Set des données pour cet événement
            $start = $interclubsVeteran->getDateRencontre();
            $end = $interclubsVeteran->getDateRencontre();
            $titre = $interclubsVeteran->getName();
            $desc = 'Evénement créé par la création de la rencontre '.$interclubsVeteran->getName();
            $cat = 'Interclub';
            
            // Appel de la création de l'événement depuis son Controller avec l'EntityManager
            $ec->create($this->em, $start, $end, $titre, $desc, $cat);
            $this->addFlash('success','Evénement créé avec succès !');

            // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
            $lieuRepository = new LieuRepository($this->registry);
            if ($interclubsVeteran->getLocation()) {
                $lieu = $lieuRepository->find($interclubsVeteran->getLocation());
            }

            // MAJ le lieu à partir de l'id location si non null
            if ($lieu) {
                $interclubsVeteran->setLieu($lieu);
            }
            
            // Sauvegarde de la rencontre Interclub puis retour vers la liste des Interclubs
            $this->em->persist($interclubsVeteran);
            $this->em->flush();
            $this->addFlash('success','Rencontre "'.$interclubsVeteran->getName().'" créée avec succès !');
            return $this->redirectToRoute('interclubVeteran.index');
        }

        return $this->render('interclub_veteran/new.html.twig', [
            'interclubForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/interclubveteran/{id}", name="interclubVeteran.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(InterclubVeteran $interclubsVeteran, Request $request): Response
    {
        $form = $this->createForm(InterclubVeteranType::class, $interclubsVeteran);
        $form->handleRequest($request);
        $lieu = null;

        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère l'objet Team pour le nom donné en paramètre de la query method GET
            $lieuRepository = new LieuRepository($this->registry);
            if ($interclubsVeteran->getLocation()) {
                $lieu = $lieuRepository->find($interclubsVeteran->getLocation());
            }

            // MAJ le lieu à partir de l'id location si non null
            if ($lieu) {
                $interclubsVeteran->setLieu($lieu);
            }

            // Sauvegarde de la rencontre Interclub puis retour vers la liste des Interclubs
            $this->em->flush();
            $this->addFlash('success','Rencontre "'.$interclubsVeteran->getName().'" modifiée avec succès !');
            return $this->redirectToRoute('interclubVeteran.index');
        }

        return $this->render('interclub_veteran/edit.html.twig', [
            'interclubsVeteran'     => $interclubsVeteran,
            'interclubForm' => $form->createView()
        ]);
    }

    /**
    * @Route("/admin/interclubveteran/teamhome-select", name="interclubveteran_teamhome_select")
    */
    public function getLocationSelect(Request $request)
    {
        $interclubsVeteran = new InterclubVeteran();

        // Récupère l'objet TeamVeteran pour le nom donné en paramètre de la query method GET
        $teamRepository = new TeamVeteranRepository($this->registry);
        $teamhome = $teamRepository->find($request->query->get('teamhome'),null,null);

        // MAJ la donnée teamhome pour l'Interclub Vétéran
        $interclubsVeteran->setTeamHome($teamhome);
        $form = $this->createForm(InterclubVeteranType::class, $interclubsVeteran);

        // no location? Return an empty response
        if (!$form->has('location')) {
            return new Response(null, 204);
        }

        return $this->render('admin/interclubveteran/location.html.twig', [
            'interclubForm' => $form->createView(),
        ]);

    }    

}

