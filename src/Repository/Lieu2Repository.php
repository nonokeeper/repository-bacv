<?php

namespace App\Repository;

use App\Entity\Lieu2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Lieu2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lieu2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lieu2[]    findAll()
 * @method Lieu2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Lieu2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieu2::class);
    }

    // /**
    //  * @return Lieu2[] Returns an array of Lieu2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lieu2
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
