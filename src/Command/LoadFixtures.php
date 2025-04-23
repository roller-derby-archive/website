<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Club;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'fixtures:load')]
final class LoadFixtures extends Command
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
        $this->entityManager->getRepository(Club::class)->cleanAll();
        $this->entityManager->getRepository(Team::class)->cleanAll();

        $clubs = $this->serializer->deserialize(file_get_contents(__DIR__.'/../../fixtures/clubs.json'), Club::class.'[]', 'json');

        foreach ($clubs as $club) {
            $clubMap[$club->getId()] = $club;
            $this->entityManager->persist($club);
        }

        $teams = $this->serializer->deserialize(file_get_contents(__DIR__.'/../../fixtures/teams.json'), Team::class.'[]', 'json');

        /** @var Team $team */
        foreach ($teams as $team) {
            $team->setCountryCode("FRA");

            foreach ($team->getClubs() as $fakeClub) {
                $team->AddClub($clubMap[$fakeClub->getId()]);
                $team->removeClub($fakeClub);
            }

            $this->entityManager->persist($team);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
