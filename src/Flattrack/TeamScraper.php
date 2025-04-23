<?php

namespace App\Flattrack;

use Exception;
use PHPHtmlParser\Dom;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class TeamScraper
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    /**
     * Scrap a team on flattrack
     *
     * Output [
     *    'name' => {string},
     *    'logoUrl' => {string},
     *    'city' => {string},
     * ]
     *
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function scrapTeam(int $teamId): array
    {
        // Retrieve html
        $response = $this->client->request('GET', Flattrack::GetTeamPath($teamId));
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
        // <div class="vitals stats">
        //    <table>
        //        <tbody>
        //            <tr>
        //                <td><div><img class="... imagecache-profile ..." href="{logoUrl}"></div></td>
        //                <td><div class="leaguename">{name}</div></div></td>
        //            </tr>
        //            <tr>
        //                <table>
        //                   <tbody>
        //                      <tbody>
        //                         <tr>
        //                           <td>
        //                             <div>{city}</div>
        //                <td></td>
        //            </tr>
        $city = $dom
            ->find( '.vitals')[0] // <div class="vitals stats"><table>
            ->getChildren()[1] // <tbody>
            ->getChildren()[3] // <tr>
            ->getChildren()[1] // <table>
            ->getChildren()[1] // <tbody>
            ->getChildren()[1] // <tr>
            ->getChildren()[1] // <td>
            ->getChildren()[1] // <div>
        ;

        return [
            'name' => $dom->find('.leaguename')[0]->innerHtml,
            'logoUrl' => $dom->find('.imagecache-profile')[0]->getAttribute('src'),
            'city' => $city->innerHtml,
        ];
    }
}
