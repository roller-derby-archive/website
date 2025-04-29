<?php

namespace App\Repository;

use App\Entity\FlattrackRanking;
use App\Flattrack\Gender;
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

    public function isRankable(int $id): bool
    {
        $queryBuilder = new QueryBuilder($this->getEntityManager()->getConnection());
        $queryBuilder
            ->select("t.flattrack_id")
            ->from('team', 't')
            ->where('t.flattrack_id = :flattrackId')
            ->andWhere('t.disband_at ISNULL')
            ->andWhere("t.country_code = 'FRA'")
            ->setParameter("flattrackId", $id)
        ;

        if ($queryBuilder->executeQuery()->fetchOne()) {
            return true;
        }

        return false;
    }

    public function findWithRank(Gender $gender): array
    {
        return $this->getEntityManager()->getConnection()->executeQuery("
            SELECT ft.id, ft.rating, ft.european_rank, ft.french_rank , t.id as team_id, t.name, t.pronoun, t.logo_name, t.type, t.level
            FROM flattrack_ranking ft
            INNER JOIN team t ON ft.id = t.flattrack_id
            WHERE ft.gender = :gender
            AND t.disband_at ISNULL
            ORDER BY ft.european_rank 
        ", ['gender' => $gender->value]
        )->fetchAllAssociative();
    }

    public function totalRows(Gender $gender): int
    {
        return $this->getEntityManager()->getConnection()->executeQuery("
            SELECT count(*) 
            FROM flattrack_ranking ft
            INNER JOIN team t ON ft.id = t.flattrack_id
            WHERE ft.gender = :gender AND t.disband_at ISNULL
            ", ['gender' => $gender->value]
        )->fetchOne();
    }
}
