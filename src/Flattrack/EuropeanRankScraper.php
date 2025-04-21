<?php

namespace App\Flattrack;

use Exception;
use PHPHtmlParser\Dom;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class EuropeanRankScraper
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    /**
     * Scrap all european team rank on flattrack ranking page
     *
     * Output [
     *    'totalEuropeanRankedTeam' => {int},
     *    'rankedTeams' => [
     *       [
     *           'teamId' => {int},
     *           'europeanRank' => {int},
     *           'rating' => {int},
     *       ],
     *    ],
     * ]
     *
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function scrapRanks(Gender $gender): array
    {
        // Retrieve html
        $response = $this->client->request('GET', Flattrack::GetEuropeanRankingPath($gender));
        if ($response->getStatusCode() !== 200) {
            throw new Exception("Invalid gender");
        }

        // Body string to Dom object
        $dom = new Dom();
        $dom->load($response->getContent());

        return $this->parseHtml($dom);
    }

    private function parseHtml(Dom $dom): array
    {
        $output = [
            'totalEuropeanRankedTeam' => 0,
            'rankedTeams' => [],
        ];

        // html target:
        // Waring: rightflush class is a weak anchor.
        //
        // <div class="... rightflush">
        //    <table>...</table>
        //    <table>
        //        " "
        //        <thead>
        //        " "
        //        <tbody> <-- ->getChildren()[3]
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
            ->find( '.rightflush')[0] // <div class="... rightflush">
            ->getChildren()[1] // <table>
            ->getChildren()[3] // <tbody>
        ;

        // parse <tr>
        foreach ($contents as $content) {
            // Filter " " nodes
            if ($content->innerHtml === " ") {continue;}


            $row = $content->getChildren(); // <td> x 4
            $output['totalEuropeanRankedTeam']++;
            $output['rankedTeams'][] = [
                'teamId' => (int)$row[0]->getAttribute('nid'), //   <td nid="{teamId}">{europeanRank}</td>
                'europeanRank' => (int)str_replace('.', '', $row[0]->innerHtml), //  <td nid="{teamId}">{europeanRank}</td>
                'rating' => $row[3]->innerHtml, // <td>{rating}</td>
            ];
        }

        return $output;
    }
}
