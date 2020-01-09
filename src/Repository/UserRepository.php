<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\AgeCategory;
use App\Repository\ClubRepository;
use App\Repository\AgeCategoryRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->registry = $registry;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return AgeCategory Returns the AgeCategory of the User
    * @param \DateTimeInterface $birthDate
    */
    public function getAgeCategorie($birthDate)
    {
        $acRepository = new AgeCategoryRepository($this->registry);

        $idAge = 0;
        if ($birthDate) {
            $annee = (int) $birthDate->format('Y');
            if ($annee > 1898) {
                $currentYear = (int) date('Y');
                $currentMonth = date('m');
                // Test pour connaître la saison en cours : si m entre 01 et 07 alors année courante de la saison = année - 1 sinon saison = année
                $listeMois = array("01", "02", "03", "04", "05", "06", "07");
                if (in_array($currentMonth, $listeMois)) {
                    $anneeSaison = $currentYear - 1;
                } else $anneeSaison = $currentYear;
                
                $diff = $anneeSaison - $annee;
                
                if ($diff < 8){
                    $idAge = 1; // MiniBad
                } else if ($diff >= 8 && $diff < 10){
                    $idAge = 2; // Poussin
                } else if ($diff >= 10 && $diff < 12){
                    $idAge = 3; // Benjamin
                } else if ($diff >= 12 && $diff < 14){
                    $idAge = 4; // Minime
                } else if ($diff >= 14 && $diff < 16){
                    $idAge = 5; // Cadet
                } else if ($diff >= 16 && $diff < 18){
                    $idAge = 6; // Junior
                } else if ($diff >= 18 && $diff < 35){
                    $idAge = 7; // Senior
                } else if ($diff >= 35 && $diff < 40){
                    $idAge = 8; // Vétéran 1
                } else if ($diff >= 40 && $diff < 45){
                    $idAge = 9; // Vétéran 2
                } else if ($diff >= 45 && $diff < 50){
                    $idAge = 10; // Vétéran 3
                } else if ($diff >= 50 && $diff < 55){
                    $idAge = 11; // Vétéran 4
                } else if ($diff >= 55 && $diff < 60){
                    $idAge = 12; // Vétéran 5
                } else if ($diff >= 60 && $diff < 65){
                    $idAge = 13; // Vétéran 6
                } else if ($diff >= 65 && $diff < 70){
                    $idAge = 14; // Vétéran 7
                } else if ($diff >= 70){
                    $idAge = 15; // Vétéran 8
                } else $idAge = 0;
            }
        }

       // Récupération de l'objet AgeCategory à partir de l'identifiant déterminé
        $age = $acRepository->find($idAge,null,null);
        return $age;
    }

    /**
    * @return User Returns the User object
    */
    public function findByName($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
    * @return User[] Returns the Users of $team
    * @param Int $team
    */
    public function findAllVIP($team)
    {
        // Inscrit cette saison <=> champ 'active' = 1
        // Joueurs de l'équipe $team
        return $this->createQueryBuilder('u')
            ->addSelect('substring(u.classement_simple,2,2)*100 + substring(u.classement_double,2,2)*10 + substring(u.classement_mixte,2,2)*1 as HIDDEN classement')
            ->andWhere('u.team = :team')
            ->setParameter('team', $team)
            ->andWhere('u.active = :active')
            ->setParameter('active', 1)
            ->orderBy('classement')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Query Returns the Query of User objects
    * @param string $team
    * @param string $groupe
    * @param string $libre
    */
    public function findPaginatedByTeam($team, $groupe, $libre)
    {
        $repositoryClub = new ClubRepository($this->registry);
        $club = $repositoryClub->findClubBySlug('BACV');
        
        // Joueurs du club BACV <=> champ 'club' = "Villepreux",
        // Joueur de l'équipe sélectionnée en filtre si NON VIDE (!)
        // Critère de catégorie <=> groupe
        // Critère de recherche Libre
        $query = $this->createQueryBuilder('u');
        if($club) {
            $query->andWhere('u.club = :club')
                ->setParameter('club', $club);
        }
        if($team) {
            $query->andWhere('u.team = :team')
                ->setParameter('team', $team);
        }
        if ($groupe) {
            $query->andWhere('u.category = :groupe')
                ->setParameter('groupe', $groupe);
        }
        if ($libre) {
            $query->andWhere('u.fullName LIKE :libre')
                ->setParameter('libre', '%'.$libre.'%');
        }
        $query->orderBy('u.lastName', 'ASC')
            ->getQuery();
        return $query;
    }

    /**
     * @return Int Returns the number of Users found
    * @param string $team
    * @param string $groupe
    * @param string $libre
    */
    public function findSearchBy($team, $groupe, $libre)
    {
        $repositoryClub = new ClubRepository($this->registry);
        $club = $repositoryClub->findClubBySlug('BACV');
        
        // Joueurs du club BACV <=> champ 'club' = "Villepreux",
        // Joueur de l'équipe sélectionnée en filtre si NON VIDE (!)
        // Critère de catégorie <=> groupe
        // Critère de recherche Libre
        $qb = $this->createQueryBuilder('u');
        if($club) {
            $qb->andWhere('u.club = :club')
                ->setParameter('club', $club);
        }
        if($team) {
            $qb->andWhere('u.team = :team')
                ->setParameter('team', $team);
        }
        if ($groupe) {
            $qb->andWhere('u.category = :groupe')
                ->setParameter('groupe', $groupe);
        }
        if ($libre) {
            $qb->andWhere('u.fullName LIKE :libre')
                ->setParameter('libre', '%'.$libre.'%');
        }

        $qb ->select($qb->expr()->count('u'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    
}