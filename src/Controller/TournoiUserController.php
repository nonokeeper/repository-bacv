<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Repository\TournoiUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\TournoiUserType;

class TournoiUserController extends AbstractController
{
    /**
     * @var TournoiUserRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(TournoiUserRepository $repository, EntityManagerInterface $em, Security $security)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * @Route("/tournoisUser", name="tournoisUser.index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(TournoiUserType::class);
        $form->handleRequest($request);

        $tournoisUser = $this->repository->findAll();
        return $this->render('tournoi_user/index.html.twig', [
            'tournoisUser'   => $tournoisUser,
            'form'          => $form->createView()
        ]);
    }
}
