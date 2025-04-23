<?php

namespace App\Flattrack;

use Exception;
use PHPHtmlParser\Dom;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class GameScraper
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    /**
     * Scrap all game on flattrack
     *
     * Output [
     *   [
     *       'playedAt' => {datetime},
     *       'gameId' => {int},
     *       'sanctioning' => {string},
     *       'ruleset' => {string},
     *       'tournamentId' => {?int},
     *       'teamA' => [
     *         'score' => {?int}
     *         'teamId' => {int}
     *       ],
     *       'teamB' => [
     *         'score' => {?int}
     *         'teamId' => {int}
     *       ],
     *   ],
     * ]
     *
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function scrapBouts(int $page): array
    {
        // Retrieve html
        $response = $this->client->request('GET', Flattrack::GetBoutsPath($page));
        if ($response->getStatusCode() !== 200) {
            throw new Exception("Http Error: " . $response->getStatusCode());
        }

        // Body string to Dom object
        $dom = new Dom();
        $dom->load($response->getContent());

        return $this->parseHtml($dom);
    }

    private function parseHtml(Dom $dom): array
    {
        $output = [];

        // html target:
        // Waring: view-content class is a weak anchor.
        //
        // <div class="view-content">
        //    <table>...</table>
        //    <table>
        //        " "
        //        <thead>
        //        " "
        //        <tbody>
        //            <tr>
        //                " "
        //                <td nid="{teamId}">{europeanRank}</td>
        //                " "
        //                <td>...</td>
        //                " "
        //                <td>...</td>
        //                " "
        //                <td>{rating}</td>
        //            </tr>
        $contents = $dom
            ->find( '.view-content')[0] // <div class="view-content">
            ->getChildren()[1] // <table>
            ->getChildren()[3] // <tbody>
        ;

        // parse <tr>
        foreach ($contents as $content) {
            // Filter " " nodes
            if ($content->innerHtml === " ") {continue;}

            $row = $content->getChildren(); // <td> x 9
            preg_match('/\d{1,2}\/\d{1,2}\/\d{1,2}/', $row[1]->innerHtml, $matches);
            $date = \DateTimeImmutable::createFromFormat('m/d/y', $matches[0]);

            // Ugly but funny
            $sanctioning = $this->extractSanctioning($row[3]);
            $ruleset = $sanctioning === null ? 'WFTDA' : $sanctioning;

            $href = $row[5]->getChildren()[1]->getAttribute('href') === null ? $row[5]->getChildren()[1]->getChildren()[0]->getAttribute('href') : $row[5]->getChildren()[1]->getAttribute('href');
            preg_match('/\d{1,10}/', $href, $matches);
            $teamAId = $matches[0];

            $href = $row[9]->getChildren()[1]->getAttribute('href') === null ? $row[9]->getChildren()[1]->getChildren()[0]->getAttribute('href') : $row[9]->getChildren()[1]->getAttribute('href');
            preg_match('/\d{1,10}/', $href, $matches);
            $teamBId = $matches[0];

            $tournamentId = null;
            if ($row[15]->innerHtml !== " ") {
                preg_match('/\d{1,10}/', $row[15]->getChildren()[1]->getAttribute('href'), $matches);
                $tournamentId = (int)$matches[0];
            }

            $output[] = [
                'playedAt' => $date, // 1 - <td> <span nid='89201'></span><span class='time'></span> {playedAt} </td>
                'gameId' => (int)$row[1]->getChildren()[1]->getAttribute('nid'), // 1 - <td> <span nid='{gameId}'></span><span class='time'></span> 6/3/17 </td>
                'sanctioning' => $sanctioning, // <div class="lighter smaller" tooltip="{sanctioning}">--</div>
                'ruleset' => $ruleset, // Guessed
                'tournamentId' => $tournamentId, // Guessed
                'teamA' => [
                    'score' => $this->extractScore($row[7]), // <span class="win">{score}</span> or {score}
                    'teamId' => (int)$teamAId, // <span class="win"><a href="/teams/{teamId}/overview">Thunder City</a></span> or <a href="/teams/{teamId}/overview">Swan City</a>
                ],
                'teamB' => [
                    'score' => $this->extractScore($row[11]),  // <span class="win">{score}</span> or {score}
                    'teamId' => (int)$teamBId, // <span class="win"><a href="/teams/{teamId}/overview">Thunder City</a></span> or <a href="/teams/{teamId}/overview">Swan City</a>
                ],
            ];
        }

        return $output;
    }

    private function extractScore($element): ?int
    {
        $total = count($element->getChildren());

        if ($total === 1) {
            $score = $element->getChildren()[0]->innerHtml;
            if (trim($score) === '') {
                return null;
            } else {
                return (int)trim($score);
            }
        } else {
            return (int)trim($element->getChildren()[1]->innerHtml);
        }
    }

    private function extractSanctioning($element): ?string {
        return match ($element->getChildren()[1]->getAttribute('tooltip')) {
            'Sanctioned By WFTDA' => 'WFTDA',
            'Sanctioned By MRDA' => 'MRDA',
            default => null,
        };
    }
}
