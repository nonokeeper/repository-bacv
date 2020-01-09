<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lieu;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu", name="lieu")
     */
    public function index()
    {
        return $this->render('lieu/index.html.twig', [
            'controller_name' => 'LieuController',
        ]);
    }

    /**
     * @Route("/lieu/{id}", name="lieu.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Lieu $lieu)
    {
        return $this->render('lieu/edit.html.twig', [
            'lieu' => $lieu,
        ]);
    }

}
