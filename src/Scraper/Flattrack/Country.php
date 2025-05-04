<?php

namespace App\Scraper\Flattrack;

use App\Enum\Country as AppCountry;

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

    public static function GetCountry(Country $country): AppCountry
    {
        return match ($country) {
            self::ARGENTINA => AppCountry::ARGENTINA,
            self::USA_TX, self::USA_CO, self::USA_CA, self::USA_LA => AppCountry::USA,
            self::BELGIUM => AppCountry::BELGIUM,
            self::SPAIN => AppCountry::SPAIN,
            self::ITALY => AppCountry::ITALY,
            self::GERMANY => AppCountry::GERMANY,
            self::UNITED_KINGDOM, self::UK_GA => AppCountry::UNITED_KINGDOM,
            self::NETHERLANDS => AppCountry::NETHERLANDS,
            self::DENMARK => AppCountry::DENMARK,
            self::IRELAND => AppCountry::IRELAND,
            self::SWITZERLAND => AppCountry::SWITZERLAND,
            self::SWEDEN => AppCountry::SWEDEN,
            self::FINLAND => AppCountry::FINLAND,
            self::AUSTRIA => AppCountry::AUSTRIA,
            self::SOUTH_AFRICA => AppCountry::SOUTH_AFRICA,
            self::MEXICO => AppCountry::MEXICO,
            self::CZECH_REPUBLIC => AppCountry::CZECH_REPUBLIC,
        };
    }
}
