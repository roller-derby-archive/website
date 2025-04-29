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

    public function getPreviousMeet(string $teamIdA, string $teamIdB): void
    {
        $this->getEntityManager()
            ->getConnection()
            ->executeQuery('SELECT * FROM game INNER JOIN team_game ON game.id = team_game.game_id');

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
