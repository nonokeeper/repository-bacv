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
    /**
     * @var string
     */
    private $currentSaison;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterclubVeteran::class);
        $this->currentSaison = $_ENV['SAISON'];
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

    /**
    * @return InterclubVeteran[] Returns an array of InterclubVeteran objects
    */
    public function findAllCurrentSaison($saison)
    {
        return $this->createQueryBuilder('iv')
            ->andWhere('iv.saison = :val')
            ->setParameter('val', $saison)
            ->orderBy('iv.dateRencontre', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return InterclubVeteran Returns one Interclub for VIPOne
    * Filtre sur les identifiants des équipes respectivement
    * Equipe Vet1 / Equipe Vet2 => 1 / 3
    */
    public function findVet1(): ?InterclubVeteran
    {
        $result = $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $this->currentSaison)
            ->andWhere('i.dateRencontre >= :date')
            ->setParameter('date', new \DateTime('now'))
            ->andWhere('i.team_home = :vip or i.team_ext = :vip')
            ->setParameter('vip', 1)
            ->orderBy('i.dateRencontre', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return ($result? $result[0] : null);
    }

    /**
    * @return InterclubVeteran Returns one Interclub for VIPTwo
    */
    public function findVet2(): ?InterclubVeteran
    {
        $result = $this->createQueryBuilder('i')
            ->andWhere('i.saison = :saison')
            ->setParameter('saison', $this->currentSaison)
            ->andWhere('i.dateRencontre >= :date')
            ->setParameter('date', new \DateTime('now'))
            ->andWhere('i.team_home = :vip or i.team_ext = :vip')
            ->setParameter('vip', 3)
            ->orderBy('i.dateRencontre', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return ($result? $result[0] : null);
    }

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
