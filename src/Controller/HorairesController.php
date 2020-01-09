<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HorairesController extends AbstractController
{
    /**
     * @Route("/horaires", name="horaires")
     */
    public function index()
    {
        return $this->render('horaires/index.html.twig', [
            'controller_name' => 'HorairesController',
        ]);
    }
}
