<?php

namespace App\Entity;

use App\Enum\TeamCategory;
use App\Enum\TeamLevel;
use App\Enum\TeamType;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[Vich\Uploadable]
class Team
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?string $overview = null;

    #[ORM\Column(nullable: true)]
    private ?string $history = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $disbandAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $flattrackId = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    // ISO 3166-1
    #[ORM\Column(length: 255)]
    private ?string $countryCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebookId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagramId = null;

    /**
     * @var Collection<int, Club>
     */
    #[ORM\ManyToMany(targetEntity: Club::class, inversedBy: 'teams')]
    private Collection $clubs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pronoun = null;

    #[ORM\Column(nullable: true)]
    private ?array $mediaLinks = null;

    /**
     * @var Collection<int, TeamGame>
     */
    #[ORM\OneToMany(targetEntity: TeamGame::class, mappedBy: 'team', orphanRemoval: true)]
    private Collection $teamGames;

    #[ORM\Embedded(class: EmbeddedFile::class)]
    private ?EmbeddedFile $logo = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'logo', fileNameProperty: 'logo.name', size: 'logo.size')]
    private ?File $logoFile = null;

    #[ORM\OneToOne(mappedBy: 'team', cascade: ['persist', 'remove'])]
    private ?FlattrackRanking $flattrackRanking = null;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
        $this->teamGames = new ArrayCollection();
        $this->logo = new EmbeddedFile();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): Team
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

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): static
    {
        $this->overview = $overview;

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(?string $history): static
    {
        $this->history = $history;

        return $this;
    }

    public function getMediaLinks(): ?array
    {
        return $this->mediaLinks;
    }

    public function setMediaLinks(?array $mediaLinks): static
    {
        $this->mediaLinks = $mediaLinks;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
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

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(null|string|TeamLevel $level): static
    {
        if ($level InstanceOf TeamLevel) {
            $level = $level->value;
        }

        $this->level = $level;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string|TeamType $type): static
    {
        if ($type InstanceOf TeamType) {
            $type = $type->value;
        }

        $this->type = $type;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): Team
    {
        $this->countryCode = $countryCode;

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

    public function getPronoun(): ?string
    {
        return $this->pronoun;
    }

    public function setPronoun(?string $pronoun): static
    {
        $this->pronoun = $pronoun;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): static
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    public function getInstagramId(): ?string
    {
        return $this->instagramId;
    }

    public function setInstagramId(?string $instagramId): static
    {
        $this->instagramId = $instagramId;

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
            $teamGame->setTeam($this);
        }

        return $this;
    }

    public function removeTeamGame(TeamGame $teamGame): static
    {
        if ($this->teamGames->removeElement($teamGame)) {
            // set the owning side to null (unless already changed)
            if ($teamGame->getTeam() === $this) {
                $teamGame->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|null $logoFile
     */
    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function setLogo(EmbeddedFile $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLogo(): ?EmbeddedFile
    {
        return $this->logo;
    }

    public function getLogoName(): ?string
    {
        return $this->logo->getName();
    }

    public function getFlattrackRanking(): ?FlattrackRanking
    {
        return $this->flattrackRanking;
    }

    public function setFlattrackRanking(FlattrackRanking $flattrackRanking): static
    {
        // set the owning side of the relation if necessary
        if ($flattrackRanking->getTeam() !== $this) {
            $flattrackRanking->setTeam($this);
        }

        $this->flattrackRanking = $flattrackRanking;

        return $this;
    }
}
