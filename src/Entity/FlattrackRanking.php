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

    #[ORM\Column]
    private ?int $europeanRank = null;

    #[ORM\Column]
    private ?int $frenchRank = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 1)]
    private ?string $rating = null;

    #[ORM\Column(length: 5)]
    private ?string $gender = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

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

    public function getFrenchRank(): ?int
    {
        return $this->frenchRank;
    }

    public function setFrenchRank(?int $frenchRank): void
    {
        $this->frenchRank = $frenchRank;
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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }
}
