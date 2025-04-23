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
     *       'teamA' => [
     *         'score' => {?int}
     *         'teamId' => {int}
     *       ],
     *       'gameId' => {int},
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
            ->find( '.view-content')[0] // <div class="... rightflush">
            ->getChildren()[1] // <table>
            ->getChildren()[3] // <tbody>
        ;

        // parse <tr>
        foreach ($contents as $content) {
            // Filter " " nodes
            if ($content->innerHtml === " ") {continue;}


            $row = $content->getChildren(); // <td> x 4
            $output['rankedTeams'][] = [
                'teamId' => (int)$row[0]->getAttribute('nid'), //   <td nid="{teamId}">{europeanRank}</td>
                'europeanRank' => (int)str_replace('.', '', $row[0]->innerHtml), //  <td nid="{teamId}">{europeanRank}</td>
                'rating' => $row[3]->innerHtml, // <td>{rating}</td>
            ];
        }

        return $output;
    }
}
