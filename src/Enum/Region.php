<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * ISO 3166-2:FR (https://fr.wikipedia.org/wiki/ISO_3166-2:FR)
 *
 * @author Alexandre Tomatis <alexandre.tomatis@gmail.com>
 */
enum Region: string
{
    case FrAra = 'FR-ARA';
    case FrBfc = 'FR-BFC';
    case FrBre = 'FR-BRE';
    case FrCvl = 'FR-CVL';
    case FrGes = 'FR-GES';
    case FrHdf = 'FR-HDF';
    case FrIdf = 'FR-IDF';
    case FrNor = 'FR-NOR';
    case FrNaq = 'FR-NAQ';
    case FrOcc = 'FR-OCC';
    case FrPdl = 'FR-PDL';
    case FrPac = 'FR-PAC';
    case Fr20r = 'FR-20R';
    case Fr974 = 'FR-974';

    private const map = [
        self::FrAra->value => 'Auvergne-Rhône-Alpes',
        self::FrBfc->value => 'Bourgogne-Franche-Comté',
        self::FrBre->value => 'Bretagne',
        self::FrCvl->value => 'Centre-Val de Loire',
        self::FrGes->value => 'Grand Est',
        self::FrHdf->value => 'Hauts-de-France',
        self::FrIdf->value => 'Île-de-France',
        self::FrNor->value => 'Normandie',
        self::FrNaq->value => 'Nouvelle-Aquitaine',
        self::FrOcc->value => 'Occitanie',
        self::FrPdl->value => 'Pays de la Loire',
        self::FrPac->value => 'Provence-Alpes-Côte d’Azur',
        self::Fr20r->value => 'Corse',
        self::Fr974->value => 'La Réunion',
    ];

    // ISO 3166-2:FR
    static function getName(string $regionCode): string
    {
        return self::map[$regionCode];
    }
}
