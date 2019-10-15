<?php

namespace App\Repository;

use App\Entity\InterclubVeteranUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InterclubVeteranUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterclubVeteranUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterclubVeteranUser[]    findAll()
 * @method InterclubVeteranUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterclubVeteranUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterclubVeteranUser::class);
    }

    // /**
    //  * @return InterclubVeteranUser[] Returns an array of InterclubVeteranUser objects
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
    public function findOneBySomeField($value): ?InterclubVeteranUser
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
