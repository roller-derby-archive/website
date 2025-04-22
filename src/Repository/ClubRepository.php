<?php

namespace App\Repository;

use App\Entity\Club;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Club>
 */
class ClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Club::class);
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
        return $this->getEntityManager()->getConnection()->executeQuery('SELECT count(*) FROM club WHERE closed_at IS NULL')->fetchOne();
    }

    public function countAll(): int|false
    {
        return $this->getEntityManager()->getConnection()->executeQuery('SELECT count(*) FROM club')->fetchOne();
    }
}
