<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('index.html.twig', [
            'users' => $users
        ]);
    }
}
