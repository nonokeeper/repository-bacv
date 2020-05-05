<?php

namespace App\Repository;

use App\Entity\InterclubUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findMyInterclubs($user)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.user = :user')
            ->setParameter('user', $user)
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByInterclub($interclub)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.interclub = :interclub')
            ->setParameter('interclub', $interclub)
            ->getQuery()
            ->getResult();
        ;
    }

    /**
    * @return User[] 
    * Joueurs notés présents pour cet interclub
    */
    public function findPresents($interclubId)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.interclub = :interclub')
            ->setParameter('interclub', $interclubId)
            ->andWhere('i.type = :type')
            ->setParameter('type', 'Présence')
            ->andWhere('i.value = :value')
            ->setParameter('value', 'Oui')
            ->getQuery()
            ->getResult();
        ;
    }

    public function findMyInterclub($interclub, $user, $type)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.user = :user')
            ->setParameter('user', $user)
            ->andWhere('i.interclub = :interclub')
            ->setParameter('interclub', $interclub)
            ->andWhere('i.type = :type')
            ->setParameter('type', $type)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }
}
