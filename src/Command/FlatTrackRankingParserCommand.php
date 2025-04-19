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
#[AsCommand(name: 'app:parse-flat-track')]
final class FlatTrackRankingParserCommand extends Command
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
        // check data folder
        if (!is_dir(__DIR__.'/../../var/data')) {
            mkdir(__DIR__.'/../../var/data', 0777, true);
        }

        $this->entityManager->getRepository(FlattrackRanking::class)->cleanAll();
        $this->parseRanking('women');
        $this->parseRanking('men');

        return Command::SUCCESS;
    }

    private function parseRanking(string $gender): void
    {
        if (!in_array($gender, ['women', 'men'])) {
            throw new \Exception("Invalid gender in flattrack parse rank function");
        }

        $response = $this->client->request('GET', sprintf("https://www.flattrackstats.com/rankings/%s/%s_europe", $gender, $gender ));

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Invalid gender in flattrack parse rank function");
        }

        $dom = new Dom();
        $dom->load($response->getContent());
        // <div class="... rightflush"> <-- find( '.rightflush')[0]
        //    <table></table>
        //    <table> <-- ->getChildren()[1]
        //        " " --> ??
        //        <thead>
        //        " " --> ??
        //        <tbody> <-- ->getChildren()[3]
        //            <tr>
        //                " " --> ??
        //                <td nid="{teamId}">{europeanRank}</td>
        //                " " --> ??
        //                <td>...</td>
        //                " " --> ??
        //                <td>...</td>
        //                " " --> ??
        //                <td>{rating}</td>
        //            </tr>
        $contents = $dom->find( '.rightflush')[0]->getChildren()[1]->getChildren()[3];

        $totalEuropeanTeamNumber = 0;

        // parse <tr>
        foreach ($contents as $content) {
            // Filter " " nodes
            if ($content->innerHtml === " ") {continue;}
            $row = $content->getChildren();
            $totalEuropeanTeamNumber++;

            if (!$this->entityManager->getRepository(FlattrackRanking::class)->checkId((int)$row[0]->getAttribute('nid'))) {
                continue;
            }

            $rank = new FlattrackRanking();
            $rank->setId((int)$row[0]->getAttribute('nid'));
            $rank->setEuropeanRank((int)str_replace('.', '', $row[0]->innerHtml));
            $rank->setRating($row[3]->innerHtml);
            $rank->setCategory($gender);

            $this->entityManager->persist($rank);
        }

        $this->entityManager->flush();
        file_put_contents(__DIR__.sprintf('/../../var/data/total_%s_european_team_number', $gender), $totalEuropeanTeamNumber);
    }
}
