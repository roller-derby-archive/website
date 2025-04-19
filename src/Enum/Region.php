<?php

declare(strict_types=1);

namespace App\Enum;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class Region
{
    // ISO 3166-2:FR (https://fr.wikipedia.org/wiki/ISO_3166-2:FR)
    const FR_ARA = 'FR-ARA';
    const FR_BFC = 'FR-BFC';
    const FR_BRE = 'FR-BRE';
    const FR_CVL = 'FR-CVL';
    const FR_GES = 'FR-GES';
    const FR_HDF = 'FR-HDF';
    const FR_IDF = 'FR-IDF';
    const FR_NOR = 'FR-NOR';
    const FR_NAQ = 'FR-NAQ';
    const FR_OCC = 'FR-OCC';
    const FR_PDL = 'FR-PDL';
    const FR_PAC = 'FR-PAC';
    const FR_20R = 'FR-20R';
    const FR_974 = 'FR-974';


    private const map = [
        self::FR_ARA => 'Auvergne-Rhône-Alpes',
        self::FR_BFC => 'Bourgogne-Franche-Comté',
        self::FR_BRE => 'Bretagne',
        self::FR_CVL => 'Centre-Val de Loire',
        self::FR_GES => 'Grand Est',
        self::FR_HDF => 'Hauts-de-France',
        self::FR_IDF => 'Île-de-France',
        self::FR_NOR => 'Normandie',
        self::FR_NAQ => 'Nouvelle-Aquitaine',
        self::FR_OCC => 'Occitanie',
        self::FR_PDL => 'Pays de la Loire',
        self::FR_PAC => 'Provence-Alpes-Côte d’Azur',
        self::FR_20R => 'Corse',
        self::FR_974 => 'La Réunion',
    ];

    /** @param string $regionCode ISO 3166-2:FR */
    static function getName(string $regionCode): string
    {
        return self::map[$regionCode];
    }
}
