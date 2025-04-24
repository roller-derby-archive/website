<?php

namespace App\Repository\DBAL;
use Doctrine\DBAL\Connection;

class SearchViewRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {}

    public function search(string $needle): array
    {
        return $this->connection->executeQuery('SELECT * FROM view__search WHERE value like :needle LIMIT 6', ['needle' => "%$needle%"])->fetchAllAssociative();
    }
}