<?php

namespace App\Entity;

use App\Repository\FlattrackRankingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlattrackRankingRepository::class)]
class FlattrackRanking
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL)]
    private ?string $rating = null;

    #[ORM\Column]
    private ?int $europeanRank = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(string $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getEuropeanRank(): ?int
    {
        return $this->europeanRank;
    }

    public function setEuropeanRank(int $europeanRank): static
    {
        $this->europeanRank = $europeanRank;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}
