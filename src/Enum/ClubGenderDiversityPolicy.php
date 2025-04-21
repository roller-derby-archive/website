<?php

declare(strict_types=1);

namespace App\Enum;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
enum ClubGenderDiversityPolicy: string
{
    case ChosenNonMixity = 'NMC';
    case Mixed = 'M';
    private const map = [
        self::ChosenNonMixity->value => 'Non-mixité choisie',
        self::Mixed->value => 'Mixte',
    ];

    static function getName(string $letters): string
    {
        return self::map[$letters];
    }
}
