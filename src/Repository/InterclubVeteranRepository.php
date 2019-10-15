<?php

namespace App\Repository;

use App\Entity\InterclubVeteran;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InterclubVeteran|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterclubVeteran|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterclubVeteran[]    findAll()
 * @method InterclubVeteran[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterclubVeteranRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterclubVeteran::class);
    }

    // /**
    //  * @return InterclubVeteran[] Returns an array of InterclubVeteran objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InterclubVeteran
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
