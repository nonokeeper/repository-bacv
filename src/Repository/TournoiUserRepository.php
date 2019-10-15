<?php

namespace App\Repository;

use App\Entity\TournoiUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TournoiUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TournoiUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TournoiUser[]    findAll()
 * @method TournoiUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournoiUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TournoiUser::class);
    }

    // /**
    //  * @return TournoiUser[] Returns an array of TournoiUser objects
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
    public function findOneBySomeField($value): ?TournoiUser
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
