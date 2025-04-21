<?php

declare(strict_types=1);

namespace App\Enum;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
enum TeamCategory: string
{
    case WomenAndGenderMinorities = 'F+';
    case Mixed = 'M';
    case Junior = 'J';

    private const map = [
        self::WomenAndGenderMinorities->value => 'F+',
        self::Mixed->value => 'Mixte',
        self::Junior->value => 'Junior',
    ];

    static function getName(string $category): string
    {
        return self::map[$category];
    }
}
