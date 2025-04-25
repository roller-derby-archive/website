<?php

namespace App\Flattrack;

enum Country: string
{
    case BELGIUM = 'Belgium';
    case SPAIN = 'Spain';
    case ITALY = 'Italy';
    case GERMANY = 'Germany';
    case UNITED_KINGDOM = 'UK';
    case NETHERLANDS = 'Netherlands';
    case ARGENTINA = 'Argentina';
    case DENMARK = 'Denmark';
    case IRELAND = 'Ireland';
    case SWITZERLAND = 'Switzerland';
    case SWEDEN = 'Sweden';
    case FINLAND = 'Finland';
    case AUSTRIA = 'Austria';
    case SOUTH_AFRICA = 'South Africa';
    case MEXICO = 'Mexico';
    case CZECH_REPUBLIC = 'Czech Republic';
    case USA_TX = 'TX';
    case USA_CO = 'CO';
    case USA_CA = 'CA';
    case USA_LA = 'LA';
    case UK_GA = 'Wales';

    public static function GetCountryCode(Country $country): string
    {
        return match ($country) {
            self::ARGENTINA => 'ARG',
            self::BELGIUM => 'BEL',
            self::SPAIN => 'ESP',
            self::ITALY => 'ITA',
            self::GERMANY => 'DEU',
            self::UNITED_KINGDOM, self::UK_GA => 'GBR',
            self::NETHERLANDS => 'NLD',
            self::DENMARK => 'DNK',
            self::IRELAND => 'IRL',
            self::SWITZERLAND => 'CHE',
            self::SWEDEN => 'SWE',
            self::FINLAND => 'FIN',
            self::AUSTRIA => 'AUT',
            self::SOUTH_AFRICA => 'ZAF',
            self::MEXICO => 'MEX',
            self::CZECH_REPUBLIC => 'CZE',
            self::USA_TX, self::USA_CO, self::USA_CA, self::USA_LA => 'USA',
        };
    }
}
