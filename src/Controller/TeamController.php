<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TeamType;
use App\Form\TeamVeteranType;
use App\Form\UserFormType;
use App\Entity\Team;
use App\Entity\TeamVeteran;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use App\Repository\SaisonRepository;
use App\Repository\TeamVeteranRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class TeamController extends AbstractController
{
    /**
     * @var TeamRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(TeamRepository $repository, EntityManagerInterface $em, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->registry = $registry;
    }

    /**
     * @Route("/teams", name="team.index")
     */
    public function index(Request $request): Response
    {
        $formVeteran = $this->createForm(TeamVeteranType::class);
        $form = $this->createForm(TeamType::class);
        $saison = $_ENV['SAISON'];

        $teams = $this->repository->findAllBACV($saison);
        $repositoryVeteran = new TeamVeteranRepository($this->registry);
        $teamsVeteran = $repositoryVeteran->findAllBACV($saison);

        $saisonRepository = new SaisonRepository($this->registry);
        $saison = $saisonRepository->find($saison)->getName();

        $userRepository = new UserRepository($this->registry);

        // Revoir ce code avec les ID en dur si changement dans les équipes de Villepreux
        $usersVIP1 = $userRepository->findAllVIP(1);
        $usersVIP2 = $userRepository->findAllVIP(2);
        $usersVIP3 = $userRepository->findAllVIP(4);
        $usersVIP4 = $userRepository->findAllVIP(5);

        return $this->render('team/index.html.twig', [
            'form'          => $form->createView(),
            'teams'         => $teams,
            'formVeteran'   => $formVeteran->createView(),
            'teamsVeteran'  => $teamsVeteran,
            'saison'        => $saison,
            'usersVIP1'     => $usersVIP1,
            'usersVIP2'     => $usersVIP2,
            'usersVIP3'     => $usersVIP3,
            'usersVIP4'     => $usersVIP4
        ]);
    }

    /**
     * @Route("/team/{slug}", name="team.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Team $team, Request $request): Response
    {
        $formTeam = $this->createForm(TeamType::class, $team);
        $formTeam->handleRequest($request);

        if ($formTeam->isSubmitted() && $formTeam->isValid())
        {
            echo 'edit Team';
            $this->em->flush();
            $this->addFlash('success','Equipe "'. $team->getName() . '" mise à jour avec succès');
            return $this->redirectToRoute('team.index');
        }
        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'formTeam' => $formTeam->createView()
        ]);
    }

    /**
     * @Route("/teamVeteran/{slug}", name="teamVeteran.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editVeteran(TeamVeteran $teamVeteran, Request $request): Response
    {
        $formTeamVeteran = $this->createForm(TeamVeteranType::class, $teamVeteran);
        $formTeamVeteran->handleRequest($request);

        if ($formTeamVeteran->isSubmitted() && $formTeamVeteran->isValid())
        {
            echo 'edit TeamVeteran';
            $this->em->flush();
            $this->addFlash('success','Equipe Vétéran "'. $teamVeteran->getName() . '" mise à jour avec succès');
            return $this->redirectToRoute('team.index');
        }
        return $this->render('team/editVeteran.html.twig', [
            'teamVeteran' => $teamVeteran,
            'formTeamVeteran' => $formTeamVeteran->createView()
        ]);
    }
}