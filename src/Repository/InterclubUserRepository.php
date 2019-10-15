<?php

namespace App\Repository;

use App\Entity\InterclubUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InterclubUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterclubUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterclubUser[]    findAll()
 * @method InterclubUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterclubUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterclubUser::class);
    }

    // /**
    //  * @return InterclubUser[] Returns an array of InterclubUser objects
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
    public function findOneBySomeField($value): ?InterclubUser
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
