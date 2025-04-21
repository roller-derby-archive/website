<?php

namespace App\Flattrack;

use Exception;

class Flattrack
{
    const WEBSITE_URL = 'https://www.flattrackstats.com';
    const PATH_WOMEN_EUROPEAN_RANKING = '/rankings/women/women_europe';
    const PATH_MEN_EUROPEAN_RANKING = '/rankings/men/men_europe';
    const PATH_TEAMS = '/teams';

    /**  @throws Exception */
    public static function GetEuropeanRankingPath(Gender $gender): string
    {
        switch ($gender) {
            case Gender::Women:
                return sprintf('%s/%s', self::WEBSITE_URL, self::PATH_WOMEN_EUROPEAN_RANKING);
            case Gender::Men:
                return sprintf('%s/%s', self::WEBSITE_URL, self::PATH_MEN_EUROPEAN_RANKING);
        }

        throw new Exception("Invalid gender");
    }

    public static function GetTeamsPath(int $flattrackId): string
    {
         return sprintf('%s/%s/%s', self::WEBSITE_URL, self::PATH_TEAMS, $flattrackId);
    }
}
