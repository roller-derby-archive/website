<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?string $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $playedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $flattrackGameId = null;

    #[ORM\Column]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?string $sanctioning = null;

    #[ORM\Column]
    private ?string $ruleset = null;

    /**
     * @var Collection<int, TeamGame>
     */
    #[ORM\OneToMany(targetEntity: TeamGame::class, mappedBy: 'game', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $teamGames;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Event $event = null;

    public function __construct()
    {
        $this->teamGames = new ArrayCollection();
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

    public function getPlayedAt(): ?\DateTimeImmutable
    {
        return $this->playedAt;
    }

    public function setPlayedAt(\DateTimeImmutable $playedAt): static
    {
        $this->playedAt = $playedAt;

        return $this;
    }

    public function getFlattrackGameId(): ?int
    {
        return $this->flattrackGameId;
    }

    public function setFlattrackGameId(?int $flattrackGameId): static
    {
        $this->flattrackGameId = $flattrackGameId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSanctioning(): ?string
    {
        return $this->sanctioning;
    }

    public function setSanctioning(?string $sanctioning): self
    {
        $this->sanctioning = $sanctioning;

        return $this;
    }

    public function getRuleset(): ?string
    {
        return $this->ruleset;
    }

    public function setRuleset(?string $ruleset): self
    {
        $this->ruleset = $ruleset;

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
            $teamGame->setGame($this);
        }

        return $this;
    }

    public function removeTeamGame(TeamGame $teamGame): static
    {
        if ($this->teamGames->removeElement($teamGame)) {
            // set the owning side to null (unless already changed)
            if ($teamGame->getGame() === $this) {
                $teamGame->setGame(null);
            }
        }

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
}
