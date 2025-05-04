<?php

namespace App\Repository;

use App\Entity\FlattrackRanking;
use App\Enum\Country;
use App\Scraper\Flattrack\Gender;
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

    public function findByGender(Gender $gender): array
    {
        $queryBuilder = $this->createQueryBuilder('fr');
        $queryBuilder
            ->join('fr.team', 't')
            ->where('t.disbandAt IS NULL')
            ->where('t.countryCode = :countryCode')
            ->andWhere('fr.gender = :gender')
            ->setParameter('countryCode', Country::FRANCE->value)
            ->setParameter('gender', $gender->value)
            ->orderBy('fr.europeanRank', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    public function totalRows(Gender $gender): int
    {
        return $this->getEntityManager()->getConnection()->executeQuery("
            SELECT count(*) 
            FROM flattrack_ranking ft
            INNER JOIN team t ON ft.id = t.flattrack_id
            WHERE ft.gender = :gender AND t.disband_at ISNULL AND t.country_code = :country_code
            ", ['gender' => $gender->value, 'country_code' => Country::FRANCE->value]
        )->fetchOne();
    }
}
