<?php

namespace App\Controller;

use App\Entity\LienDoodle;
use App\Entity\Personne;
use App\Repository\DoodleRepository;
use App\Repository\LienDoodleRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class LienDoodleController extends AbstractController
{
    public function __construct(LienDoodleRepository $Lrep, PersonneRepository $Prep, DoodleRepository $Drep, EntityManagerInterface $em, Security $security)
    {
        $this->Drep = $Drep;
        $this->Prep = $Prep;
        $this->Lrep = $Lrep;
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * @Route("/lienDoodle", name="lienDoodle.save")
     */
    public function save(Request $request) : Response
    {
        $doodleId = $request->request->get('doodle');
        $pseudo = $request->request->get('personne');
        $doodle = $this->Drep->find($doodleId);
        // $personne à créer si pseudo n'existe pas déjà sinon récupérer son id
        // Ecraser les valeurs de LienDoodle si pseudo déjà existant
        $personne = $this->Prep->findOneBy(['pseudo' => $pseudo]);
        if(!$personne){
            $personne = new Personne();
            $personne->setPseudo($pseudo);
            $personne->setDoodle($doodle);
            $this->em->persist($personne);
            $this->em->flush();
            $personne = $this->Prep->findOneBy(['pseudo' => $pseudo]);
        }

        $items = $doodle->getItems();
        // boucler sur les items pour récupérer les valeurs saisies
        foreach($items as $item) {
            if ($doodle->getType() == 'checkbox' ) {
                $value = $request->request->getBoolean('value-'.$item->getId());
            } else {
                $value = $request->request->get('value-'.$item->getId());
            }
            // test $exist : Lien Doodle existe déjà
            $exist = true;
            $lienDoodle = $this->Lrep->findOneBy(['personne' => $personne, 'doodle' => $doodle, 'item' => $item]);
            if (!$lienDoodle) {
                $lienDoodle = new LienDoodle();
                $exist = false;
            }
            $lienDoodle->setPersonne($personne);
            $lienDoodle->setDoodle($doodle);
            $lienDoodle->setUpdatedDt(new \DateTime("now"));
            $lienDoodle->setItem($item);
            if ($doodle->getType() == 'checkbox' ) {
                if($value) {
                    $lienDoodle->setValue('1');
                }
                else {
                    $lienDoodle->setValue('0');
                }
            }
            $types = array("texte", "number", "qcm");
            if (in_array($doodle->getType(), $types)) {
                $lienDoodle->setValue($value);
            }
            if (!$exist) {
                $this->em->persist($lienDoodle);
            }
            $this->em->flush();
        }
        return $this->redirectToRoute('doodle.done', ['id' => $doodle->getId(), 'md5' => md5($doodle->getId())]);
    }
}
