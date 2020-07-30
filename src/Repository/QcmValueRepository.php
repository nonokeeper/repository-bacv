<?php

namespace App\Repository;

use App\Entity\QcmValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QcmValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method QcmValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method QcmValue[]    findAll()
 * @method QcmValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QcmValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QcmValue::class);
    }

    // /**
    //  * @return QcmValue[] Returns an array of QcmValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QcmValue
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
