<?php

namespace App\Repository;

use App\Entity\TeamVeteran;
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
}
