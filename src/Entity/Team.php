<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $disbandAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $flattrackId = null;

    #[ORM\Column(length: 255)]
    private ?string $genderScope = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level = null;

    #[ORM\Column(length: 255)]
    private ?string $letter = null;

    /**
     * @var Collection<int, Club>
     */
    #[ORM\ManyToMany(targetEntity: Club::class, inversedBy: 'teams')]
    private Collection $clubs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pronoun = null;

    /**
     * @var Collection<int, TeamGame>
     */
    #[ORM\OneToMany(targetEntity: TeamGame::class, mappedBy: 'teamId', orphanRemoval: true)]
    private Collection $teamGames;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
        $this->teamGames = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDisbandAt(): ?\DateTimeImmutable
    {
        return $this->disbandAt;
    }

    public function setDisbandAt(?\DateTimeImmutable $disbandAt): static
    {
        $this->disbandAt = $disbandAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFlattrackId(): ?int
    {
        return $this->flattrackId;
    }

    public function setFlattrackId(?int $flattrackId): static
    {
        $this->flattrackId = $flattrackId;

        return $this;
    }

    public function getGenderScope(): ?string
    {
        return $this->genderScope;
    }

    public function setGenderScope(string $genderScope): static
    {
        $this->genderScope = $genderScope;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getLetter(): ?string
    {
        return $this->letter;
    }

    public function setLetter(string $letter): static
    {
        $this->letter = $letter;

        return $this;
    }

    /**
     * @return Collection<int, Club>
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): static
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs->add($club);
        }

        return $this;
    }

    public function removeClub(Club $club): static
    {
        $this->clubs->removeElement($club);

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getPronoun(): ?string
    {
        return $this->pronoun;
    }

    public function setPronoun(?string $pronoun): static
    {
        $this->pronoun = $pronoun;

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
            $teamGame->setTeamId($this);
        }

        return $this;
    }

    public function removeTeamGame(TeamGame $teamGame): static
    {
        if ($this->teamGames->removeElement($teamGame)) {
            // set the owning side to null (unless already changed)
            if ($teamGame->getTeamId() === $this) {
                $teamGame->setTeamId(null);
            }
        }

        return $this;
    }
}
