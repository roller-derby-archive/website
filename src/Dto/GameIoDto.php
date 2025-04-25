<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Game;
use App\Entity\Team;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class GameIoDto
{
    private ?string $id = null;

    private ?\DateTimeImmutable $playedAt = null;

    private ?int $flattrackGameId = null;

    private ?string $type = null;

    private ?string $sanctioning = null;

    private ?string $ruleset = null;

    private ?string $teamIdA = null;

    private ?int $scoreA = null;

    private ?string $teamIdB = null;

    private ?int $scoreB = null;

    public function toEntity(): Game
    {
        return (new Game())
            ->setId($this->id)
            ->setPlayedAt($this->playedAt)
            ->setFlattrackGameId($this->flattrackGameId)
            ->setType($this->type)
            ->setSanctioning($this->sanctioning)
            ->setRuleset($this->ruleset)
        ;
    }

    public static function fromEntity(Game $game): self
    {
        return (new self())
            ->setId($game->getId())
            ->setPlayedAt($game->getPlayedAt())
            ->setFlattrackGameId($game->getFlattrackGameId())
            ->setType($game->getType())
            ->setSanctioning($game->getSanctioning())
            ->setRuleset($game->getRuleset())
            ->setScoreA($game->getTeamGames()[0]->getScore())
            ->setScoreB($game->getTeamGames()[1]->getScore())
            ->setTeamIdA($game->getTeamGames()[0]->getTeam()->getId())
            ->setTeamIdB($game->getTeamGames()[1]->getTeam()->getId())
        ;
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

    public function getPlayedAt(): ?\DateTimeImmutable
    {
        return $this->playedAt;
    }

    public function setPlayedAt(?\DateTimeImmutable $playedAt): self
    {
        $this->playedAt = $playedAt;
        return $this;
    }

    public function getFlattrackGameId(): ?int
    {
        return $this->flattrackGameId;
    }

    public function setFlattrackGameId(?int $flattrackGameId): self
    {
        $this->flattrackGameId = $flattrackGameId;
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

    public function getTeamIdA(): ?string
    {
        return $this->teamIdA;
    }

    public function setTeamIdA(?string $teamIdA): self
    {
        $this->teamIdA = $teamIdA;
        return $this;
    }

    public function getScoreA(): ?int
    {
        return $this->scoreA;
    }

    public function setScoreA(?int $scoreA): self
    {
        $this->scoreA = $scoreA;
        return $this;
    }

    public function getTeamIdB(): ?string
    {
        return $this->teamIdB;
    }

    public function setTeamIdB(?string $teamIdB): self
    {
        $this->teamIdB = $teamIdB;
        return $this;
    }

    public function getScoreB(): ?int
    {
        return $this->scoreB;
    }

    public function setScoreB(?int $scoreB): self
    {
        $this->scoreB = $scoreB;
        return $this;
    }
}
