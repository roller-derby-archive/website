<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Team;
use App\Flattrack\TeamScraper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;
/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'app:image-scavenge')]
final class ImageScavengerCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TeamScraper $teamScraper,
        ?string $name = null)
    {
        parent::__construct($name);
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $toUnlinkFiles = [];

        foreach ($this->entityManager->getRepository(Team::class)->findAll() as $team) {
            if ($team->getFlattrackId() !== null) {
                $ftTeam = $this->teamScraper->scrapTeam($team->getFlattrackId());
                $urlParts = explode('/', $ftTeam['logoUrl']);
                $tmpFile = __DIR__.'/../../var/'.$urlParts[count($urlParts) - 1];
                copy($ftTeam['logoUrl'], $tmpFile);
                $toUnlinkFiles[] = $tmpFile;
                $team->setLogoFile(new ReplacingFile($tmpFile));
            }
        }

        $this->entityManager->flush();

        foreach ($toUnlinkFiles as $file) {
            unlink($file);
        }

        return Command::SUCCESS;
    }
}
