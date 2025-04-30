<?php

namespace App\Repository;

use App\Entity\TeamGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamGame>
 */
class TeamGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamGame::class);
    }

    public function totalHipsPassed(): int
    {
        $hipsPassed = $this->getEntityManager()->getConnection()->executeQuery('SELECT sum(score) FROM team_game')->fetchOne();
        return $hipsPassed ?: 0;
    }
}
