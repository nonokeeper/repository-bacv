<?php

namespace App\Repository;

use App\Entity\TeamVeteran;
use App\Repository\ClubRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TeamVeteran|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamVeteran|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamVeteran[]    findAll()
 * @method TeamVeteran[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamVeteranRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamVeteran::class);
        $this->registry = $registry;
    }

    // /**
    //  * @return TeamVeteran[] Returns an array of TeamVeteran objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeamVeteran
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
    * @return TeamVeteran[] Equipes Vétéran du BACV pour la saison en cours
    */
    public function findAllBACV($saison)
    {
        $repositoryClub = new ClubRepository($this->registry);
        $club = $repositoryClub->findClubBySlug('BACV');

        $teamsVeteran = $this->createQueryBuilder('s')
                ->join('s.saison', 'saison', 'WITH', 'saison = :saison')
                ->setParameter('saison',$saison)
                ->getQuery()
                ->getResult();

        return $this->createQueryBuilder('t')
            ->andWhere('t.id IN (:id)')
            ->setParameter('id', $teamsVeteran)
            ->andWhere('t.club = :val')
            ->setParameter('val', $club)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
