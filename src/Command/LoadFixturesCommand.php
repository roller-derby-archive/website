<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\ClubIoDto;
use App\Dto\TeamIoDto;
use App\Entity\Club;
use App\Entity\Game;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'fixtures:load')]
final class LoadFixturesCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clubMap = [];
        $this->entityManager->getRepository(Game::class)->cleanAll();
        $this->entityManager->getRepository(Team::class)->cleanAll();
        $this->entityManager->getRepository(Club::class)->cleanAll();

        $clubIoDtos = $this->serializer->deserialize(file_get_contents(Fixtures::CLUB_FILE), ClubIoDto::class.'[]', 'json');

        foreach ($clubIoDtos as $clubIoDto) {
            $club = $clubIoDto->toEntity();
            foreach ($clubIoDto->getTeamIds() as $teamId) {
                $clubMap[$teamId][] = $club;
            }
            $this->entityManager->persist($club);
        }

        $teamIoDtos = $this->serializer->deserialize(file_get_contents(Fixtures::TEAM_FILE), TeamIoDto::class.'[]', 'json');

        foreach ($teamIoDtos as $teamIoDto) {
            $team = $teamIoDto->toEntity();

            foreach ($clubMap[$team->getId()] ?? [] as $club) {
                $output->writeln("+");
                $team->AddClub($club);
            }

            $this->entityManager->persist($team);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
