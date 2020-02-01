<?php

namespace App\Repository;

use App\Entity\Interclub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Interclub|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interclub|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interclub[]    findAll()
 * @method Interclub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterclubRepository extends ServiceEntityRepository
{
    private $currentSaison;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interclub::class);
        $this->currentSaison = $_ENV['SAISON'];
    }

    // /**
    //  * @return Interclub[] Returns an array of Interclub objects
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

    /**
    * @return Interclub[] Returns an array of Interclub objects
    */
    public function findAllCurrentSaison($saison)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $saison)
            ->orderBy('i.dateRencontre', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Interclub[] Returns an array of Interclub objects
    */
    public function findAllForCompo($saison)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $saison)
            ->orderBy('i.name', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Interclub Returns one Interclub for VIP1
    * Filtre sur les identifiants des équipes respectivement
    * Equipe 1 / Equipe 2 / Equipe 3 / Equipe 4 => 1 / 2 / 4 / 5 
    */
    public function findVIP1(): ?Interclub
    {
        $result = $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $this->currentSaison)
            ->andWhere('i.dateRencontre >= :date')
            ->setParameter('date', new \DateTime('now', new \DateTimeZone('Europe/Paris')))
            ->andWhere('i.team_home = :vip or i.team_ext = :vip')
            ->setParameter('vip', 1)
            ->orderBy('i.dateRencontre', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return ($result? $result[0] : null);
    }

    /**
    * @return Interclub Returns one Interclub for VIP2
    */
    public function findVIP2(): ?Interclub
    {
        $result = $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $this->currentSaison)
            ->andWhere('i.dateRencontre >= :date')
            ->setParameter('date', new \DateTime('now', new \DateTimeZone('Europe/Paris')))
            ->andWhere('i.team_home = :vip or i.team_ext = :vip')
            ->setParameter('vip', 2)
            ->orderBy('i.dateRencontre', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return ($result? $result[0] : null);
    }

    /**
    * @return Interclub Returns one Interclub for VIP3
    */
    public function findVIP3(): ?Interclub
    {
        $result = $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $this->currentSaison)
            ->andWhere('i.dateRencontre >= :date')
            ->setParameter('date', new \DateTime('now', new \DateTimeZone('Europe/Paris')))
            ->andWhere('i.team_home = :vip or i.team_ext = :vip')
            ->setParameter('vip', 4)
            ->orderBy('i.dateRencontre', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return ($result? $result[0] : null);
    }

    /**
    * @return Interclub Returns one Interclub for VIP4
    */
    public function findVIP4(): ?Interclub
    {
        $result = $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $this->currentSaison)
            ->andWhere('i.dateRencontre >= :date')
            ->setParameter('date', new \DateTime('now', new \DateTimeZone('Europe/Paris')))
            ->andWhere('i.team_home = :vip or i.team_ext = :vip')
            ->setParameter('vip', 5)
            ->orderBy('i.dateRencontre', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return ($result? $result[0] : null);
    }

    /*
    public function findOneBySomeField($value): ?Interclub
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
