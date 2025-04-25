<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Team;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class TeamIoDto
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $overview = null;

    private ?string $history = null;

    private ?\DateTimeImmutable $disbandAt = null;

    private ?\DateTimeImmutable $createdAt = null;

    private ?int $flattrackId = null;

    private ?string $category = null;

    private ?string $level = null;

    private ?string $type = null;

    private ?string $countryCode = null;

    private ?string $email = null;

    private ?string $facebookId = null;

    private ?string $instagramId = null;

    private ?string $pronoun = null;

    private ?array $mediaLinks = null;

    private ?EmbeddedFile $logo = null;

    public function toEntity(): Team
    {
        return (new Team())
            ->setId($this->id)
            ->setName($this->name)
            ->setEmail($this->email)
            ->setCreatedAt($this->createdAt)
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setLevel($this->level)
            ->setType($this->type)
            ->setCountryCode($this->countryCode)
            ->setFacebookId($this->facebookId)
            ->setInstagramId($this->instagramId)
            ->setPronoun($this->pronoun)
            ->setMediaLinks($this->mediaLinks)
            ->setLogo($this->logo)
            ->setDisbandAt($this->disbandAt)
            ->setOverview($this->overview)
            ->setHistory($this->history)
            ->setFlattrackId($this->flattrackId)
            ->setCategory($this->category)
        ;
    }

    public static function fromEntity(Team $team): self
    {
        $teamIoDto = (new self())
            ->setId($team->getId())
            ->setName($team->getName())
            ->setEmail($team->getEmail())
            ->setCountryCode($team->getCountryCode())
            ->setCreatedAt($team->getCreatedAt())
            ->setMediaLinks($team->getMediaLinks())
            ->setLevel($team->getLevel())
            ->setType($team->getType())
            ->setCategory($team->getCategory())
            ->setFlattrackId($team->getFlattrackId())
            ->setPronoun($team->getPronoun())
            ->setDisbandAt($team->getDisbandAt())
            ->setHistory($team->getHistory())
            ->setOverview($team->getOverview())
            ->setInstagramId($team->getInstagramId())
            ->setFacebookId($team->getFacebookId())
            ->setLogo($team->getLogo())
        ;

        return $teamIoDto;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;
        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(?string $history): self
    {
        $this->history = $history;
        return $this;
    }

    public function getDisbandAt(): ?\DateTimeImmutable
    {
        return $this->disbandAt;
    }

    public function setDisbandAt(?\DateTimeImmutable $disbandAt): self
    {
        $this->disbandAt = $disbandAt;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getFlattrackId(): ?int
    {
        return $this->flattrackId;
    }

    public function setFlattrackId(?int $flattrackId): self
    {
        $this->flattrackId = $flattrackId;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): self
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    public function getInstagramId(): ?string
    {
        return $this->instagramId;
    }

    public function setInstagramId(?string $instagramId): self
    {
        $this->instagramId = $instagramId;
        return $this;
    }

    public function getPronoun(): ?string
    {
        return $this->pronoun;
    }

    public function setPronoun(?string $pronoun): self
    {
        $this->pronoun = $pronoun;
        return $this;
    }

    public function getMediaLinks(): ?array
    {
        return $this->mediaLinks;
    }

    public function setMediaLinks(?array $mediaLinks): self
    {
        $this->mediaLinks = $mediaLinks;
        return $this;
    }

    public function getLogo(): ?EmbeddedFile
    {
        return $this->logo;
    }

    public function setLogo(?EmbeddedFile $logo): self
    {
        $this->logo = $logo;
        return $this;
    }
}
