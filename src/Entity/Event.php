<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $edition = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'event')]
    private Collection $games;

    #[ORM\Column(nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Championship $championship = null;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'previous', cascade: ['persist', 'remove'])]
    private ?self $next = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'next', cascade: ['persist', 'remove'])]
    private ?self $previous = null;

    public function __construct()
    {
        $this->games = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getEdition(): ?int
    {
        return $this->edition;
    }

    public function setEdition(?int $edition): static
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setEvent($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getEvent() === $this) {
                $game->setEvent(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getChampionship(): ?Championship
    {
        return $this->championship;
    }

    public function setChampionship(?Championship $championship): static
    {
        $this->championship = $championship;

        return $this;
    }

    public function getNext(): ?self
    {
        return $this->next;
    }

    public function setNext(?self $next): static
    {
        $this->next = $next;

        return $this;
    }

    public function getPrevious(): ?self
    {
        return $this->previous;
    }

    public function setPrevious(?self $previous): static
    {
        // unset the owning side of the relation if necessary
        if ($previous === null && $this->previous !== null) {
            $this->previous->setNext(null);
        }

        // set the owning side of the relation if necessary
        if ($previous !== null && $previous->getNext() !== $this) {
            $previous->setNext($this);
        }

        $this->previous = $previous;

        return $this;
    }
}
