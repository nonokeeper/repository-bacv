<?php

namespace App\Controller;

use App\Repository\DoodleRepository;
use App\Repository\LienDoodleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DoodleController extends AbstractController
{
    /**
     * @var DoodleRepository
     */
    private $doodleRep;

    /**
     * @var LienDoodleRepository
     */
    private $lienDoodleRep;


    public function __construct(DoodleRepository $doodleRep, LienDoodleRepository $lienDoodleRep)
    {
        $this->doodleRep = $doodleRep;
        $this->lienDoodleRep = $lienDoodleRep;
    }

    /**
     * @Route("/doodle/{id}/{md5}", name="doodle.go")
     */
    public function go($id, $md5)
    {
        $doodle = $this->doodleRep->find($id);
        $liens = $this->lienDoodleRep->findBy(['doodle' => $doodle]);
        $personnes = [];
        $cptPersonnes = 0;
        foreach($liens as $lien) {
            if ($cptPersonnes == 0 OR $personnes[$cptPersonnes-1] <> $lien->getPersonne()) {
                $personnes[$cptPersonnes] = $lien->getPersonne();
                $cptPersonnes++;
            }
        }
        $testmd5 = md5($id);
        if ($md5 == $testmd5) {
            return $this->render('doodle/index.html.twig', [
                'doodle' => $doodle,
                'personnes' => $personnes
            ]);
        } else {
            return $this->render('doodle/noway.html.twig');
        }
    }

    /**
     * @Route("/doodle_done/{id}/{md5}", name="doodle.done")
     */
    public function done($id, $md5)
    {
        $doodle = $this->doodleRep->find($id);
        $testmd5 = md5($id);
        if ($md5 == $testmd5) {
            return $this->render('doodle/done.html.twig', [
                'doodle'    => $doodle,
                'md5'       => $md5
            ]);
        } else {
            return $this->render('doodle/noway.html.twig');
        }
    }
}
