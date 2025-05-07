<?php

namespace App\Repository;

use App\Entity\Championship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Championship>
 */
class ChampionshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Championship::class);
    }
    public function countAll(): int|false
    {
        return $this->getEntityManager()->getConnection()->executeQuery('SELECT count(*) FROM championship')->fetchOne();
    }
}
