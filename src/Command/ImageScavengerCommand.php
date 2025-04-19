<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Club;
use App\Entity\FlattrackRanking;
use App\Entity\Team;
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
use function PHPUnit\Framework\isInstanceOf;
/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'app:image-scavenge')]
final class ImageScavengerCommand extends Command
{
    private readonly EntityManagerInterface $entityManager;
    private readonly HttpClientInterface $client;
    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client, ?string $name = null)
    {
        $this->entityManager = $entityManager;
        $this->client = $client;

        parent::__construct($name);
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->entityManager->getRepository(Team::class)->findAll() as $team) {
            if ($team->getFlattrackId() !== null) {
                if (is_file(__DIR__.'/../../assets/images/upload/logo_'.$team->getFlattrackId().'.webp')) {
                    continue;
                }

                $response = $this->client->request('GET', sprintf("https://www.flattrackstats.com/teams/%s", $team->getFlattrackId()));

                if ($response->getStatusCode() !== 200) {
                    throw new \Exception("Invalid gender in flattrack parse rank function");
                }

                $dom = new Dom();
                $dom->load($response->getContent());
                $url = $dom->find( '.imagecache-profile')[0]->getAttribute('src');
                $ext = substr($url, -3, 3);

                copy($url, __DIR__.'/../../assets/images/upload/logo_'.$team->getFlattrackId().'.'.$ext);
            }
        }

        return Command::SUCCESS;
    }
}
