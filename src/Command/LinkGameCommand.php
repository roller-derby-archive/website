<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\ClubIoDto;
use App\Dto\GameIoDto;
use App\Entity\Club;
use App\Entity\Game;
use App\Entity\Team;
use App\Entity\TeamGame;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'fixtures:link-game')]
final class LinkGameCommand extends Command
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface $serializer,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clubIoDtos = $this->serializer->deserialize(file_get_contents(Fixtures::GAME_FILE), GameIoDto::class.'[]', 'json');

        foreach ($clubIoDtos as $clubIoDto) {
            $game = $clubIoDto->toEntity();
            $game->addTeamGame(
                (new TeamGame())
                ->setGame($game)
                ->setTeam($this->teamRepository->find($clubIoDto->getTeamIdA()))
                ->setScore($clubIoDto->getScoreA())
                ->setLetter('A')
            );
            $game->addTeamGame(
                (new TeamGame())
                    ->setGame($game)
                    ->setTeam($this->teamRepository->find($clubIoDto->getTeamIdB()))
                    ->setScore($clubIoDto->getScoreB())
                    ->setLetter('B')
            );

            $this->entityManager->persist($game);
        }


        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
