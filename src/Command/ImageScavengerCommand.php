<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Club;
use App\Entity\FlattrackRanking;
use App\Entity\Team;
use App\Flattrack\TeamScraper;
use App\Repository\ClubRepository;
use App\Repository\FlattrackRankingRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\CurlException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use stringEncode\Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;
use function PHPUnit\Framework\isInstanceOf;
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
