<?php

namespace App\Repository;

use App\Entity\FlattrackRanking;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FlattrackRanking>
 */
class FlattrackRankingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlattrackRanking::class);
    }

    public function cleanAll(): void
    {
        $this->createQueryBuilder('c')
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }

    public function checkId(int $id): bool
    {
        $queryBuilder = new QueryBuilder($this->getEntityManager()->getConnection());
        $queryBuilder
            ->select("t.flattrack_id")
            ->from('team', 't')
            ->where('t.flattrack_id = :flattrackId')
            ->setParameter("flattrackId", $id)
        ;

        if ($queryBuilder->executeQuery()->fetchOne()) {
            return true;
        }

        return false;
    }

    public function findWithRank(string $category): array
    {
        return $this->getEntityManager()->getConnection()->executeQuery("
            SELECT ft.id, ft.rating, ft.european_rank, RANK() OVER (ORDER BY european_rank) AS french_rank , t.id as team_id, t.name, t.pronoun, t.logo, t.letter, t.level
            FROM flattrack_ranking ft
            INNER JOIN team t ON ft.id = t.flattrack_id
            WHERE category = :category
            AND t.disband_at ISNULL
        ", ['category' => $category]
        )->fetchAllAssociative();
    }
    public function findOneWithRank(int $id, string $category): false|array
    {
        return $this->getEntityManager()->getConnection()->executeQuery("
            SELECT ft.id, ft.rating, ft.european_rank, ft.french_rank
            FROM (
                SELECT sft.id, sft.rating, sft.european_rank, RANK() OVER (ORDER BY sft.european_rank) AS french_rank
                FROM flattrack_ranking sft
                INNER JOIN team t ON sft.id = t.flattrack_id
                WHERE category = :category AND t.disband_at ISNULL
            ) ft
            WHERE ft.id = :id
            
        ", ["id" => $id, 'category' => $category])->fetchAssociative();
    }

    public function totalRows(string $category): int
    {
        return $this->getEntityManager()->getConnection()->executeQuery("
            SELECT count(*) 
            FROM flattrack_ranking ft
            INNER JOIN team t ON ft.id = t.flattrack_id
            WHERE category = :category AND t.disband_at ISNULL
            ", ['category' => $category]
        )->fetchOne();
    }
}
