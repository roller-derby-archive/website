<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $playedAt = null;

    /**
     * @var Collection<int, TeamGame>
     */
    #[ORM\OneToMany(targetEntity: TeamGame::class, mappedBy: 'gameId', orphanRemoval: true)]
    private Collection $teamGames;

    public function __construct()
    {
        $this->teamGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayedAt(): ?\DateTimeImmutable
    {
        return $this->playedAt;
    }

    public function setPlayedAt(\DateTimeImmutable $playedAt): static
    {
        $this->playedAt = $playedAt;

        return $this;
    }

    /**
     * @return Collection<int, TeamGame>
     */
    public function getTeamGames(): Collection
    {
        return $this->teamGames;
    }

    public function addTeamGame(TeamGame $teamGame): static
    {
        if (!$this->teamGames->contains($teamGame)) {
            $this->teamGames->add($teamGame);
            $teamGame->setGameId($this);
        }

        return $this;
    }

    public function removeTeamGame(TeamGame $teamGame): static
    {
        if ($this->teamGames->removeElement($teamGame)) {
            // set the owning side to null (unless already changed)
            if ($teamGame->getGameId() === $this) {
                $teamGame->setGameId(null);
            }
        }

        return $this;
    }
}
