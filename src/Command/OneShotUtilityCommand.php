<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Team;
use App\Flattrack\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'app:one-shot-script')]
final class OneShotUtilityCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        ?string $name = null,
    )
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $teams = $this->entityManager->getRepository(Team::class)->findAll();

        foreach ($teams as $team) {
            if ($team->getCountryCode() != 'FRA') {
                $names = explode(', ', $team->getCountryCode());
                $country = Country::tryFrom($names[count($names) - 1]) ? Country::GetCountry(Country::from($names[count($names) - 1])) : 'UNKNOWN';
                $team->setCountryCode($country);
            }
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
