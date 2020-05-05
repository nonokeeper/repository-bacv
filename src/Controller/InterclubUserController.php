<?php

namespace App\Controller;

use App\Entity\InterclubUser;
use App\Repository\InterclubRepository;
use App\Repository\InterclubUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class InterclubUserController extends AbstractController
{
    public function __construct(UserRepository $Urep, InterclubRepository $Irep, InterclubUserRepository $IUrep, EntityManagerInterface $em, Security $security)
    {
        $this->Irep = $Irep;
        $this->IUrep = $IUrep;
        $this->Urep = $Urep;
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * @Route("/myinterclubs", name="myinterclubs")
     */
    public function index()
    {
        $user = $this->security->getUser();
        $team = null;
        if ($user) {
            $team = $user->getTeam();
        }
        $saison = $_ENV['SAISON'];
        $myInterclubs = $this->Irep->findMyInterclubs($saison, $team);
        $myInterclubsUser = $this->IUrep->findMyInterclubs($user);
        $allInterclubsUser = $this->IUrep->findAll();

        return $this->render('interclub_user/index.html.twig', [
            'interclubsUser'    => $myInterclubsUser,
            'interclubs'        => $myInterclubs,
            'allInterclubsUser' => $allInterclubsUser
        ]);
    }

    /**
     * @Route("/myinterclubsUpdate", name="myinterclubs_update")
     * @IsGranted("ROLE_USER")
     * */
    public function update(Request $request) : Response
    {
        $interclub = null;
        $type = $request->request->get('type');
        $value = $request->request->get('value');
        $id = $request->request->get('interclub');
        if ($id) {
            $interclub = $this->Irep->find($id);
        }
        $user = $this->security->getUser();
        if(!$user) {
            return $this->render('security/login.html.twig');
        }
        if (!$type || !$value || !$interclub) {
            return $this->redirectToRoute ('myinterclubs');
        }

        $IU = $this->IUrep->findMyInterclub($interclub, $user, $type);
        if (!$IU && $type) {
            $IU = new InterclubUser();
            $IU->setInterclub($interclub);
            $IU->setUser($user);
            $IU->setType($type);
            $IU->setValue($value);
            $this->em->persist($IU);
            $this->em->flush();
        } else {
            $IU->setValue($value);
            $this->em->flush();
        }
        $this->addFlash('success','Enregistré avec succès');
        return $this->redirectToRoute('myinterclubs');
    }

    /**
     * @Route("/myinterclubsEdit/{interclubId}", name="myinterclubs_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit($interclubId) : Response
    {
        $interclub = $this->Irep->find($interclubId);
        $nextInterclub = $this->Irep->findNext($interclubId);
        $previousInterclub = $this->Irep->findPrevious($interclubId);
        $interclubsUser = $this->IUrep->findByInterclub($interclub);
        $user = $this->security->getUser();
        $team = null;
        $users = null;
        if ($user) {
            $team = $user->getTeam();
            $users = $this->Urep->findAllVIP($team);
        }
        return $this->render('interclub_user/edit.html.twig', [
            'interclubsUser'    => $interclubsUser,
            'joueurs'           => $users,
            'interclub'         => $interclub,
            'interclubId'       => $interclubId,
            'nextInterclub'     => $nextInterclub,
            'previousInterclub' => $previousInterclub,
        ]);
    }

    /**
     * @Route("/compo/{interclubId}", name="compo")
     * @IsGranted("ROLE_ADMIN")
     */
    public function compo(Request $request, $interclubId) : Response
    {
        $interclub = $this->Irep->find($interclubId);
        $joueurs = $this->Urep->findPresents($interclubId);
        $type = null;
        if ($request) {
            $type = $request->request->get('type'); // 'Participe' à l'interclub
        }
        if ($type) {
            $SH1 = $request->request->get('SH1');
            $SH2 = $request->request->get('SH2');
            $SH3 = $request->request->get('SH3');
            $SH4 = $request->request->get('SH4');
            $DDJoueuse1 = $request->request->get('DDJoueuse1');
            $DDJoueuse2 = $request->request->get('DDJoueuse2');
            $DH1Joueur1 = $request->request->get('DH1Joueur1');
            $DH1Joueur2 = $request->request->get('DH1Joueur2');
            $DH2Joueur1 = $request->request->get('DH2Joueur1');
            $DH2Joueur2 = $request->request->get('DH2Joueur2');
            $DMXJoueur = $request->request->get('DMXJoueur');
            $DMXJoueuse = $request->request->get('DMXJoueuse');
    
            $joueur = $this->Urep->find($SH1);
            $interclub->setSH1($joueur);
            $joueur = $this->Urep->find($SH2);
            $interclub->setSH2($joueur);
            $joueur = $this->Urep->find($SH3);
            $interclub->setSH3($joueur);
            $joueur = $this->Urep->find($SH4);
            $interclub->setSH4($joueur);
            $joueur = $this->Urep->find($DDJoueuse1);
            $interclub->setDDJoueuse1($joueur);
            $joueur = $this->Urep->find($DDJoueuse2);
            $interclub->setDDJoueuse2($joueur);
            $joueur = $this->Urep->find($DH1Joueur1);
            $interclub->setDH1Joueur1($joueur);
            $joueur = $this->Urep->find($DH1Joueur2);
            $interclub->setDH1Joueur2($joueur);
            $joueur = $this->Urep->find($DH2Joueur1);
            $interclub->setDH2Joueur1($joueur);
            $joueur = $this->Urep->find($DH2Joueur2);
            $interclub->setDH2Joueur2($joueur);
            $joueur = $this->Urep->find($DMXJoueur);
            $interclub->setDMXJoueur($joueur);
            $joueur = $this->Urep->find($DMXJoueuse);
            $interclub->setDMXJoueuse($joueur);

            $this->em->flush();
        }

        return $this->render('interclub_user/compo.html.twig', [
            'interclub' => $interclub,
            'joueurs'   => $joueurs
        ]);
    }

    /**
     * @Route("/myinterclubsSave", name="myinterclubs_save")
     * @IsGranted("ROLE_ADMIN")
     */
    public function save(Request $request) : Response
    {
        $value = $request->request->get('value');
        $type = $request->request->get('type');
        $interclubId = $request->request->get('interclub');
        $interclub = $this->Irep->find($interclubId);
        $joueurId = $request->request->get('joueur');
        $joueur = $this->Urep->find($joueurId);
        $interclubsUserId = $this->IUrep->findMyInterclub($interclub, $joueur, $type);
        $interclubsUser = null;
        /* Sécurité vérification des valeurs indispensables */
        if (!$type || !$value || !$interclub || !$joueur) {
            return $this->redirectToRoute ('myinterclubs');
        }
        dump($value);
        dump($type);
        dump($interclubId);
        dump($joueurId);
        dump($interclubsUserId);
        // Création de la ligne InterclubsUser s'il n'existe pas encore
        if (!$interclubsUserId) {
            $interclubsUser = new InterclubUser();
            $interclubsUser->setInterclub($interclub);
            $interclubsUser->setUser($joueur);
            $interclubsUser->setType($type);
            $interclubsUser->setValue($value);
            $this->em->persist($interclubsUser);
            $this->em->flush();
        } else {
            $interclubsUser = $this->IUrep->find($interclubsUserId);
            $interclubsUser->setValue($value);
            $this->em->flush();
        }

        /* Reconstituer la liste complète des joueurs pour revenir à la liste à jour */
        $user = $this->security->getUser();
        $team = null;
        $users = null;
        if ($user) {
            $team = $user->getTeam();
            $users = $this->Urep->findAllVIP($team);
        }

        $this->addFlash('success','Enregistré avec succès');
        return $this->redirectToRoute('myinterclubs_edit', [
            'interclubsUser'    => $interclubsUser,
            'joueurs'           => $users,
            'interclub'         => $interclub,
            'interclubId'       => $interclubId
        ]);
    }
}