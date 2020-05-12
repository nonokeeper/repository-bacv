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
use App\Repository\InterclubUserRepository;
use App\Repository\TeamRepository;
use App\Repository\LieuRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
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

    public function __construct(UserRepository $Urep, InterclubRepository $repository, InterclubUserRepository $IUrep, EntityManagerInterface $em, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->IUrep = $IUrep;
        $this->Urep = $Urep;
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
     * 
     */
    public function vueCompo()
    {
        $interclubs = $this->repository->findAllForCompo($this->saison);
        return $this->render('interclub/compo.html.twig', [
            'interclubs'    => $interclubs
        ]);
    }

    /**
     * @Route("/compo/{interclubId}", name="compo")
     * @IsGranted("ROLE_ADMIN")
     */
    public function compo(Request $request, $interclubId) : Response
    {
        $interclub = $this->repository->find($interclubId);
        $joueurs = $this->IUrep->findPresents($interclubId);
        $nextInterclub = $this->repository->findNext($interclubId);
        $previousInterclub = $this->repository->findPrevious($interclubId);
        $tableau = $request->request->get('tableau');
        $joueursSelection = $request->request->get('joueurs');

        // Tableau de la compo
        // Les tests pour MAJ sont inversés pour pouvoir vider la valeur si le(s) joueur(s) est null
        if ($tableau) {
            switch ($tableau) {
                case 'SH1':
                    $joueur = $this->Urep->find($joueursSelection[0]);
                    if ($joueur and $joueur->getGender() == 'F') {
                        break; // pas de MAJ si c'est une Femme
                    }
                    $interclub->setSH1($joueur);
                    break;
                case 'SH2':
                    $joueur = $this->Urep->find($joueursSelection[0]);
                    if ($joueur and $joueur->getGender() == 'F') {
                        break; // pas de MAJ si c'est une Femme
                    }
                    $interclub->setSH2($joueur);
                    break;
                case 'SH3':
                    $joueur = $this->Urep->find($joueursSelection[0]);
                    if ($joueur and $joueur->getGender() == 'F') {
                        break; // pas de MAJ si c'est une Femme
                    }
                    $interclub->setSH3($joueur);
                    break;
                case 'SH4':
                    $joueur = $this->Urep->find($joueursSelection[0]);
                    if ($joueur and $joueur->getGender() == 'F') {
                        break; // pas de MAJ si c'est une Femme
                    }
                    $interclub->setSH4($joueur);
                    break;
                case 'SD':
                    $joueur = $this->Urep->find($joueursSelection[0]);
                    if ($joueur and $joueur->getGender() == 'H') {
                        break; // pas de MAJ si c'est un Homme
                    }
                    $interclub->setSD($joueur);
                    break;
                case 'DH1':
                    if (!$joueursSelection) {
                        $interclub->setDH1Joueur1(null);
                        $interclub->setDH1Joueur2(null);
                    } else {
                        $joueur1 = $this->Urep->find($joueursSelection[0]);
                        $joueur2 = $this->Urep->find($joueursSelection[1]);
                        if (($joueur1 and $joueur1->getGender() == 'F') or ($joueur2 and $joueur2->getGender() == 'F')) {
                            break;
                        }
                        $interclub->setDH1Joueur1($joueur1);
                        $interclub->setDH1Joueur2($joueur2);
                    }
                    break;
                case 'DH2':
                    $joueur1 = $this->Urep->find($joueursSelection[0]);
                    $joueur2 = $this->Urep->find($joueursSelection[1]);
                    if (($joueur1 and $joueur1->getGender() == 'F') or ($joueur2 and $joueur2->getGender() == 'F')) {
                        break;
                    }
                    $interclub->setDH2Joueur1($joueur1);
                    $interclub->setDH2Joueur2($joueur2);
                    break;
                case 'DD':
                    $joueuse1 = $this->Urep->find($joueursSelection[0]);
                    $joueuse2 = $this->Urep->find($joueursSelection[1]);
                    if (($joueuse1 and $joueuse1->getGender() == 'H') or ($joueuse2 and $joueuse2->getGender() == 'H')) {
                        break;
                    }
                    $interclub->setDDJoueuse1($joueuse1);
                    $interclub->setDDJoueuse2($joueuse2);
                    break;
                case 'DMX': // logique un peu différente ici
                    $joueur1 = $this->Urep->find($joueursSelection[0]);
                    $joueur2 = $this->Urep->find($joueursSelection[1]);
                    if ($joueursSelection == [0,0]) {
                        $interclub->setDMXJoueur($joueur1);
                        $interclub->setDMXJoueuse($joueur2);
                        break;
                    } else {
                        if ($joueur1->getGender() == 'H' and $joueur2->getGender() == 'F') {
                            $interclub->setDMXJoueur($joueur1);
                            $interclub->setDMXJoueuse($joueur2);
                            break;
                        }
                        if ($joueur1->getGender() == 'F' and $joueur2->getGender() == 'H') {
                            $interclub->setDMXJoueur($joueur2);
                            $interclub->setDMXJoueuse($joueur1);
                            break;
                        }
                    }
                    break;
                }

            $this->em->flush();
            $this->addFlash('success','Modification prise en compte avec succès !');
        }

        return $this->render('interclub_user/compo.html.twig', [
            'interclub' => $interclub,
            'joueurs'   => $joueurs,
            'nextInterclub'     => $nextInterclub,
            'previousInterclub' => $previousInterclub,
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
            
            if ($formMasculin->get('saveAndQuit')->isClicked()) {
                return $this->redirectToRoute('interclub.index');
            } else {
                return $this->redirectToRoute('interclub.edit', ['id' => $id]);
            }
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
