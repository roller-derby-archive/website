<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'app:image-converter')]
final class ImageConverterCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TeamRepository $teamRepository,
        ?string $name = null
    )
    {
        parent::__construct($name);
    }

    function execute(InputInterface $input, OutputInterface $output): int
    {
        $files = scandir(__DIR__.'/../../assets/images/upload/');

        foreach ($files as $file) {
            if ($file === '.' || $file === '..' ) {
                continue;
            }

            $teamId = str_replace(['.jpg', '.jpeg', '.png'], '', $file);
            $teamId = str_replace(['logo_'], '', $teamId);

            $team = $this->teamRepository->findOneBy(['flattrackId' => $teamId]);

            if (!$team) {$output->writeln('not found');continue;}

            $team->setLogoFile(new ReplacingFile(__DIR__.'/../../assets/images/upload/'.$file));
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
