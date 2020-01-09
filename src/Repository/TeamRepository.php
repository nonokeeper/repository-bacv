<?php

namespace App\Repository;

use App\Entity\Team;
use App\Repository\ClubRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
        $this->registry = $registry;
    }

    /**
      * @return Team[] Equipes du BACV pour la saison en cours
      */
    public function findAllBACV($saison)
    {
        $repositoryClub = new ClubRepository($this->registry);
        $club = $repositoryClub->findClubBySlug('BACV');

        $teams = $this->createQueryBuilder('s')
                ->join('s.saison', 'saison', 'WITH', 'saison = :saison')
                ->setParameter('saison',$saison)
                ->getQuery()
                ->getResult();

        return $this->createQueryBuilder('t')
            ->andWhere('t.id IN (:id)')
            ->setParameter('id', $teams)
            ->andWhere('t.club = :val')
            ->setParameter('val', $club)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
      * @return Team Equipe dont le nom est $name
      */
    public function findByName($name): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
