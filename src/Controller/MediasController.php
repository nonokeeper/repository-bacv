<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MediasController extends AbstractController
{
    /**
     * @Route("/medias", name="medias")
     */
    public function index()
    {
        return $this->render('medias/index.html.twig', [
            'controller_name' => 'MediasController',
        ]);
    }
}
