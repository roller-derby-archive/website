<?php

namespace App\Flattrack;

use Exception;

class Flattrack
{
    const WEBSITE_URL = 'https://www.flattrackstats.com';
    const PATH_WOMEN_EUROPEAN_RANKING = '/rankings/women/women_europe';
    const PATH_MEN_EUROPEAN_RANKING = '/rankings/men/men_europe';
    const PATH_TEAMS = '/teams';
    const PATH_BOUTS = '/bouts';

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

    public static function GetTeamPath(int $flattrackId): string
    {
         return sprintf('%s/%s/%s', self::WEBSITE_URL, self::PATH_TEAMS, $flattrackId);
    }

    public static function GetBoutsPath(int $page): string
    {
        return sprintf('%s/%s?page=%s', self::WEBSITE_URL, self::PATH_BOUTS, $page);
    }
}
