<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\TeamGame;
use App\Flattrack\GameScraper;
use App\Flattrack\TeamScraper;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'flattrack:scrap-bouts')]
final class FlatTrackGameParserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TeamRepository $teamRepository,
        private readonly GameScraper $gameScraper,
        private readonly TeamScraper $teamScraper,
        ?string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $newTeamPersisted = [];

        for ($i = 1500;$i > 1490;$i--) {
            $bouts = $this->gameScraper->scrapBouts($i);

            foreach ($bouts as $bout) {
                $teamA = $newTeamPersisted[$bout['teamA']['teamId']] ?? $this->teamRepository->findOneBy(['flattrackId' => $bout['teamA']['teamId']]);
                $teamB = $newTeamPersisted[$bout['teamB']['teamId']] ?? $this->teamRepository->findOneBy(['flattrackId' => $bout['teamB']['teamId']]);

                if (($teamA === null && $teamB === null)) {
                    continue;
                }

                $notAFrenchTeam = 0;
                if ($teamA !== null) {
                    $notAFrenchTeam += $teamA->getCountryCode() === 'FRA' ? 0 : 1;
                } else {
                    $notAFrenchTeam++;
                }
                if ($teamB !== null) {
                    $notAFrenchTeam += $teamB->getCountryCode() === 'FRA' ? 0 : 1;
                } else {
                    $notAFrenchTeam++;
                }

                if ($notAFrenchTeam > 1) {
                    continue;
                }

                if ($teamA === null || $teamB === null) {
                    $teamKey = $teamA === null ? 'teamA' : 'teamB';
                    $teamFrench = $teamA !== null ? $teamA : $teamB;
                    $team = $this->teamScraper->scrapTeam($bout[$teamKey]['teamId']);
                    $teamMissing = (New Team())
                        ->setId(Uuid::v4()->toString())
                        ->setName($team['name'])
                        ->setType('A')
                        ->setCountryCode($team['country'])
                        ->setFlattrackId($bout[$teamKey]['teamId'])
                        ->setCreatedAt(\DateTimeImmutable::createFromFormat('d/m/Y h:i:s', '01/01/1900 00:00:00'))
                        ->setUpdatedAt(\DateTimeImmutable::createFromFormat('d/m/Y h:i:s', '01/01/1900 00:00:00'))
                        ->setCategory($teamFrench->getCategory())
                    ;
                    $this->entityManager->persist($teamMissing);
                    $newTeamPersisted[$bout['teamA']['teamId']] = $teamMissing;

                    if ($teamA === null) {
                        $teamA = $teamMissing;
                    }

                    if ($teamB === null) {
                        $teamB = $teamMissing;
                    }
                }

                $game = (new Game())
                    ->setId(Uuid::v4()->toString())
                    ->setFlattrackGameId($bout['gameId'])
                    ->setPlayedAt($bout['playedAt'])
                    ->setRuleset($bout['ruleset'])
                    ->setSanctioning($bout['sanctioning'])
                    ->setType("classed")
                    ->addTeamGame((new TeamGame())
                        ->setLetter('A')
                        ->setTeam($teamA)
                        ->setScore($bout['teamA']['score'])
                    )
                    ->addTeamGame((new TeamGame())
                        ->setLetter('B')
                        ->setTeam($teamB)
                        ->setScore($bout['teamB']['score'])
                    )
                ;

                $output->writeln(sprintf('<info>%s: %s VS %s</info>', $game->getPlayedAt()->format('d:m:Y'), $teamA->getName(), $teamB->getName()));
                $this->entityManager->persist($game);
            }

            $this->entityManager->flush();
            $output->writeln('page '.$i.' scraped');
        }

        return Command::SUCCESS;
    }
}
