<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Club;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class ClubIoDto
{
    private string $id;

    private string $name;

    private string $regionCode;

    private string $countyCode;

    private \DateTimeImmutable $createdAt;

    private ?string $email = null;

    private ?string $legalName = null;

    private ?string $legalId = null;

    private ?string $alias = null;

    private ?string $overview = null;

    private ?string $history = null;

    private array $teamIds;

    private ?string $genderDiversityPolicy = null;

    private ?\DateTimeImmutable $closedAt = null;

    private array $cities = [];

    private ?array $websites = null;

    private ?array $mediaLinks = null;

    private ?string $interleagueEmail = null;

    private ?string $facebookId = null;

    private ?string $instagramId = null;

    private ?string $myRollerDerbyId = null;

    private ?string $logoName = null;
    private ?int $logoSize = null;
    private ?string $logoMimeType = null;
    private ?string $dimensions = null;

    public function toEntity(): Club
    {
        return (new Club())
            ->setId($this->id)
            ->setName($this->name)
            ->setEmail($this->email)
            ->setRegionCode($this->regionCode)
            ->setCountyCode($this->countyCode)
            ->setCreatedAt($this->createdAt)
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setLegalName($this->legalName)
            ->setLegalId($this->legalId)
            ->setAlias($this->alias)
            ->setOverview($this->overview)
            ->setHistory($this->history)
            ->setGenderDiversityPolicy($this->genderDiversityPolicy)
            ->setClosedAt($this->closedAt)
            ->setCities($this->cities)
            ->setWebsites($this->websites)
            ->setInterleagueEmail($this->interleagueEmail)
            ->setFacebookId($this->facebookId)
            ->setInstagramId($this->instagramId)
            ->setMyRollerDerbyId($this->myRollerDerbyId)
            ->setMediaLinks($this->mediaLinks)
        ;
    }

    public static function fromEntity(Club $club): self
    {
        $clubIoDto = (new self())
            ->setId($club->getId())
            ->setName($club->getName())
            ->setEmail($club->getEmail())
            ->setRegionCode($club->getRegionCode())
            ->setCountyCode($club->getCountyCode())
            ->setCreatedAt($club->getCreatedAt())
            ->setLegalName($club->getLegalName())
            ->setLegalId($club->getLegalId())
            ->setAlias($club->getAlias())
            ->setOverview($club->getOverview())
            ->setHistory($club->getHistory())
            ->setGenderDiversityPolicy($club->getGenderDiversityPolicy())
            ->setClosedAt($club->getClosedAt())
            ->setCities($club->getCities())
            ->setWebsites($club->getWebsites())
            ->setInterleagueEmail($club->getInterleagueEmail())
            ->setFacebookId($club->getFacebookId())
            ->setInstagramId($club->getInstagramId())
            ->setMyRollerDerbyId($club->getMyRollerDerbyId())
            ->setMediaLinks($club->getMediaLinks())
        ;

        $teamIds = [];
        foreach ($club->getTeams() as $team) {
            $teamIds[] = $team->getId();
        }

        $clubIoDto->setTeamIds($teamIds);

        return $clubIoDto;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function getRegionCode(): string
    {
        return $this->regionCode;
    }

    public function setRegionCode(string $regionCode): self
    {
        $this->regionCode = $regionCode;
        return $this;
    }

    public function getCountyCode(): string
    {
        return $this->countyCode;
    }

    public function setCountyCode(string $countyCode): self
    {
        $this->countyCode = $countyCode;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    public function setLegalName(?string $legalName): self
    {
        $this->legalName = $legalName;
        return $this;
    }

    public function getLegalId(): ?string
    {
        return $this->legalId;
    }

    public function setLegalId(?string $legalId): self
    {
        $this->legalId = $legalId;
        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;
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

    public function getTeamIds(): array
    {
        return $this->teamIds;
    }

    public function setTeamIds(array $teamIds): self
    {
        $this->teamIds = $teamIds;
        return $this;
    }

    public function getGenderDiversityPolicy(): ?string
    {
        return $this->genderDiversityPolicy;
    }

    public function setGenderDiversityPolicy(?string $genderDiversityPolicy): self
    {
        $this->genderDiversityPolicy = $genderDiversityPolicy;
        return $this;
    }

    public function getClosedAt(): ?\DateTimeImmutable
    {
        return $this->closedAt;
    }

    public function setClosedAt(?\DateTimeImmutable $closedAt): self
    {
        $this->closedAt = $closedAt;
        return $this;
    }

    public function getCities(): array
    {
        return $this->cities;
    }

    public function setCities(array $cities): self
    {
        $this->cities = $cities;
        return $this;
    }

    public function getWebsites(): ?array
    {
        return $this->websites;
    }

    public function setWebsites(?array $websites): self
    {
        $this->websites = $websites;
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

    public function getInterleagueEmail(): ?string
    {
        return $this->interleagueEmail;
    }

    public function setInterleagueEmail(?string $interleagueEmail): self
    {
        $this->interleagueEmail = $interleagueEmail;
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

    public function getMyRollerDerbyId(): ?string
    {
        return $this->myRollerDerbyId;
    }

    public function setMyRollerDerbyId(?string $myRollerDerbyId): self
    {
        $this->myRollerDerbyId = $myRollerDerbyId;
        return $this;
    }

    public function getLogoName(): ?string
    {
        return $this->logoName;
    }

    public function setLogoName(?string $logoName): self
    {
        $this->logoName = $logoName;
        return $this;
    }

    public function getLogoSize(): ?int
    {
        return $this->logoSize;
    }

    public function setLogoSize(?int $logoSize): self
    {
        $this->logoSize = $logoSize;
        return $this;
    }

    public function getLogoMimeType(): ?string
    {
        return $this->logoMimeType;
    }

    public function setLogoMimeType(?string $logoMimeType): self
    {
        $this->logoMimeType = $logoMimeType;
        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): self
    {
        $this->dimensions = $dimensions;
        return $this;
    }
}
