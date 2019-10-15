<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->user = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/user/{username}", name="user.showEdit", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function showEdit(User $user, Request $request)
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success','Profil enregistré avec succès');
            return $this->redirectToRoute('user.showEdit', ['username' => $user->getUsername()]);
        }

        return $this->render('user/showEdit.html.twig', [
            'user' => $user,
            'formUser' => $form->createView()
        ]);
    }

}