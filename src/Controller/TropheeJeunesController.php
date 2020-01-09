<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TropheeJeunesController extends AbstractController
{
    /**
     * @Route("/tropheejeunes", name="tropheejeunes")
     */
    public function index()
    {
        return $this->render('trophee_jeunes/index.html.twig', [
            'controller_name' => 'TropheeJeunesController',
        ]);
    }
}
