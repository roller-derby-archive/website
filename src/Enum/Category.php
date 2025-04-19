<?php

declare(strict_types=1);

namespace App\Enum;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class Category
{
    const F = 'F+';
    const M = 'M';
    const J = 'J';

    private const map = [
        self::F => 'F+',
        self::M => 'Mixte',
        self::J => 'Junior',
    ];

    static function getName(string $category): string
    {
        return self::map[$category];
    }
}
