<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function cleanAll(): void
    {
        $this->createQueryBuilder('c')
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }

    public function countActive(): int|false
    {
        return $this->getEntityManager()->getConnection()->executeQuery('SELECT count(*) FROM team WHERE disband_at IS NULL')->fetchOne();
    }

    public function countAll(): int|false
    {
        return $this->getEntityManager()->getConnection()->executeQuery('SELECT count(*) FROM team')->fetchOne();
    }
}
