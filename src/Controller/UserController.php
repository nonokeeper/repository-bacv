<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\UserSearch;
use App\Entity\Team;
use App\Repository\UserRepository;
use App\Repository\SaisonRepository;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Form\UserEditFormType;
use App\Form\UserResetFormType;
use App\Form\UserCreateFormType;
use App\Form\UserSearchType;
use App\Form\UserCompteFormType;
use App\Form\UserMdpFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormError;
use Knp\Component\Pager\PaginatorInterface;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(UserRepository $repository, EntityManagerInterface $em, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->registry = $registry;
    }

    /**
     * @Route("/user/new", name="user.new", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserCreateFormType::class, $user);
        $form->handleRequest($request);
        $clubRepository = new ClubRepository($this->registry);
        $club = $clubRepository->findClubBySlug('BACV');

        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupération de la date saisie pour la Date de naissance
            $birthDate = $form->get('birthDate')->getData();
            
            // Appel à la fonction de calcul de la catégorie d'âge à partir de la date de naissance 
            // => getAgeCategorie dans UserRepository
            $userRep = new UserRepository($this->registry);
            $ageCat = $userRep->getAgeCategorie($birthDate);
            $user->setAgeCategory($ageCat);

            // Analyse Roles
            $roles = $form->get('roles')->getData();
            $user->setRoles(array($roles[0]));

            // Mot de passe lors de la création défini par défaut : username
            // Le Username est défini en général par prenom.nom
            $encoded = $passwordEncoder->encodePassword($user,$user->getUsername());
            $user->setPassword($encoded);
            $user->setClub($club);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success','Joueur '.$user->getUsername().' créé avec succès');
            return $this->redirectToRoute('user.index');
        }

        return $this->render('user/new.html.twig', [
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/moncompte", name="moncompte", methods="GET|POST")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function monCompte(Request $request , UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserCompteFormType::class, $user);
        $formMdp = $this->createForm(UserMdpFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupération de la date saisie pour la Date de naissance
            $birthDate = $form->get('birthDate')->getData();
            
            // Appel à la fonction de calcul de la catégorie d'âge à partir de la date de naissance 
            // => getAgeCategorie dans UserRepository
            $userRep = new UserRepository($this->registry);
            $ageCat = $userRep->getAgeCategorie($birthDate);
            $user->setAgeCategory($ageCat);
            $this->em->flush();
            $this->addFlash('success','Profil enregistré avec succès');
            return $this->redirectToRoute('moncompte', ['username' => $user->getUsername()]);
        }

        $formMdp->handleRequest($request);

        if ($formMdp->isSubmitted() && $formMdp->isValid()) {

            // Récupération des zones saisies pour les mots de passe
            $oldPassword = $formMdp->get('oldPassword')->getData();
            $newPassword = $formMdp->get('plainPassword')->getData();

            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
                $user->setPassword($newEncodedPassword);
                
                $this->em->flush();
                $this->addFlash('success', 'Mot de passe changé avec succès !');

                return $this->redirectToRoute('moncompte', ['username' => $user->getUsername()]);
            } else {
                $formMdp->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('user/showEdit.html.twig', [
            'user'      => $user,
            'formUser'  => $form->createView(),
            'formMdp'  => $formMdp->createView()
        ]);
    }

    /**
     * @Route("/users", name="user.index")
     * @param Request $request
     * @param PaginatorInterface $pi
     * @return Response
     */
    public function index(PaginatorInterface $pi, Request $request): Response
    {
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $saison = $_ENV['SAISON'];
        $saisonRepository = new SaisonRepository($this->registry);
        $saison = $saisonRepository->find($saison)->getName();

        $team = $form->get('team')->getData();
        $groupe = $form->get('category')->getData();
        $libre = $form->get('libre')->getData();

        $users = $pi->paginate(
            $this->repository->findPaginatedByTeam($team, $groupe, $libre),
            $request->query->getInt('page', 1, 10)
        );
        // Comptage de tous les résultats de la recherche
        $count = $this->repository->findSearchBy($team, $groupe, $libre);

        return $this->render('user/index.html.twig', [
            'users'         => $users,
            'count'         => $count,
            'formSearch'    => $form->createView()
        ]);
    }

    /**
     * @Route("/userReset/{username}", name="user.reset", methods="GET|POST")
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function reset(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserResetFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Mot de passe lors de la création défini par défaut : username
            // Le Username est défini en général par prenom.nom
            $encoded = $passwordEncoder->encodePassword($user,$user->getUsername());
            $user->setPassword($encoded);
            $this->em->flush();
            $this->addFlash('success','Mot de passe réinitialisé avec succès');
            return $this->redirectToRoute('user.reset', ['username' => $user->getUsername()]);
        }

        return $this->render('user/reset.html.twig', [
            'user' => $user,
            'formResetUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/userEdit/{username}", name="user.edit", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function edit(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupération de la date saisie pour la Date de naissance
            $birthDate = $form->get('birthDate')->getData();
            
            // Appel à la fonction de calcul de la catégorie d'âge à partir de la date de naissance 
            // => getAgeCategorie dans UserRepository
            $userRep = new UserRepository($this->registry);
            $ageCat = $userRep->getAgeCategorie($birthDate);
            $user->setAgeCategory($ageCat);
        
            $this->em->flush();
            $this->addFlash('success','Joueur "'. $user->getUsername() . '" mis à jour avec succès');
            return $this->redirectToRoute('user.index');
            
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/userDelete/{username}", name="user.delete", methods="GET")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */

    public function delete(User $user, Request $request)
    {
        $title = $user->getUsername();
        $this->em->remove($user);
        $this->em->flush();
        $this->addFlash('success','Joueur "'.$title.'" supprimé avec succès');
        return $this->redirectToRoute('user.index');
    }

}