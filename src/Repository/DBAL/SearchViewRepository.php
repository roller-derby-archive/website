<?php

namespace App\Repository\DBAL;
use Doctrine\DBAL\Connection;

readonly class SearchViewRepository
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function search(string $needle): array
    {
        return $this->connection->executeQuery('SELECT DISTINCT(id, name, entity), id, name, entity FROM view__search WHERE value like :needle ORDER BY entity LIMIT 10', ['needle' => "%$needle%"])->fetchAllAssociative();
    }

    public function searchTeam(string $needle): array
    {
        return $this->connection->executeQuery('SELECT DISTINCT(id, name, entity), id, name, entity FROM view__search WHERE value like :needle ORDER BY entity LIMIT 10', ['needle' => "%$needle%"])->fetchAllAssociative();
    }
}
