<?php

namespace App\Entity;

use App\Enum\ChampionshipDivision;
use App\Enum\TeamCategory;
use App\Repository\ChampionshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: ChampionshipRepository::class)]
class Championship
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $division = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'championship')]
    private Collection $events;

    #[ORM\Column(length: 255)]
    private ?string $season = null;

    /**
     * @var Collection<int, ChampionshipRanking>
     */
    #[ORM\OneToMany(targetEntity: ChampionshipRanking::class, mappedBy: 'championship', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $championshipRankings;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->championshipRankings = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDivision(): ?string
    {
        return $this->division;
    }

    public function setDivision(string|ChampionshipDivision $division): static
    {
        if ($division InstanceOf ChampionshipDivision) {
            $division = $division->value;
        }

        $this->division = $division;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string|TeamCategory $category): static
    {
        if ($category InstanceOf TeamCategory) {
            $category = $category->value;
        }

        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setChampionship($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getChampionship() === $this) {
                $event->setChampionship(null);
            }
        }

        return $this;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(string $season): static
    {
        $this->season = $season;

        return $this;
    }

    /**
     * @return Collection<int, ChampionshipRanking>
     */
    public function getChampionshipRankings(): Collection
    {
        return $this->championshipRankings;
    }

    public function addChampionshipRanking(ChampionshipRanking $championshipRanking): static
    {
        if (!$this->championshipRankings->contains($championshipRanking)) {
            $this->championshipRankings->add($championshipRanking);
            $championshipRanking->setChampionship($this);
        }

        return $this;
    }

    public function removeChampionshipRanking(ChampionshipRanking $championshipRanking): static
    {
        if ($this->championshipRankings->removeElement($championshipRanking)) {
            // set the owning side to null (unless already changed)
            if ($championshipRanking->getChampionship() === $this) {
                $championshipRanking->setChampionship(null);
            }
        }

        return $this;
    }
}
