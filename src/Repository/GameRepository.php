<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function cleanAll(): void
    {
        $this->getEntityManager()->getConnection()->executeQuery('DELETE FROM team_game');
        $this->createQueryBuilder('c')
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }

    public function countAll(): int|false
    {
        return $this->getEntityManager()->getConnection()->executeQuery('SELECT count(*) FROM game')->fetchOne();
    }
}
