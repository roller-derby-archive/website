<?php

declare(strict_types=1);

namespace App\App\Command;

use App\Dto\ClubIoDto;
use App\Dto\GameIoDto;
use App\Dto\TeamIoDto;
use App\Repository\ClubRepository;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'fixtures:dump')]
final class DumpFixturesCommand extends Command
{
    public function __construct(
        private readonly ClubRepository $clubRepository,
        private readonly TeamRepository $teamRepository,
        private readonly GameRepository $gameRepository,
        private readonly SerializerInterface $serializer,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clubs = $this->clubRepository->findAll();
        $clubsIoDto = [];
        foreach ($clubs as $club) {
            $clubsIoDto[] = ClubIoDto::fromEntity($club);
        }

        $json = $this->serializer->serialize($clubsIoDto, 'json');
        file_put_contents(Fixtures::CLUB_TMP_FILE, $json);

        unset($clubs);

        $teams = $this->teamRepository->findAll();
        $teamsIoDto = [];
        foreach ($teams as $team) {
            $teamsIoDto[] = TeamIoDto::fromEntity($team);
        }

        $json = $this->serializer->serialize($teamsIoDto, 'json');
        file_put_contents(Fixtures::TEAM_TMP_FILE, $json);

        unset($teams);

        $games = $this->gameRepository->findAll();
        $gamesIoDto = [];
        foreach ($games as $game) {
            $gamesIoDto[] = GameIoDto::fromEntity($game);
        }

        $json = $this->serializer->serialize($gamesIoDto, 'json');
        file_put_contents(Fixtures::GAME_TMP_FILE, $json);

        unset($games);

        if (is_file(Fixtures::CLUB_FILE)) {
            rename(Fixtures::CLUB_FILE, Fixtures::CLUB_OLD_FILE);
        }

        if (is_file(Fixtures::TEAM_FILE)) {
            rename(Fixtures::TEAM_FILE, Fixtures::TEAM_OLD_FILE);
        }

        if (is_file(Fixtures::GAME_FILE)) {
            rename(Fixtures::GAME_FILE, Fixtures::GAME_OLD_FILE);
        }

        rename(Fixtures::CLUB_TMP_FILE, Fixtures::CLUB_FILE);
        rename(Fixtures::TEAM_TMP_FILE, Fixtures::TEAM_FILE);
        rename(Fixtures::GAME_TMP_FILE, Fixtures::GAME_FILE);

        return Command::SUCCESS;
    }
}
