<?php

declare(strict_types=1);

namespace App\Enum;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
enum TeamType: string
{
    case TeamA = 'A';
    case TeamB = 'B';
    case TeamC = 'C';
    case TeamD = 'D';
    case TeamE = 'E';
    case Alliance = 'S';
    case Regional = 'R';
    case National = 'N';

    private const map = [
        self::TeamA->value => 'Équipe A',
        self::TeamB->value => 'Équipe B',
        self::TeamC->value => 'Équipe C',
        self::TeamD->value => 'Équipe D',
        self::TeamE->value => 'Équipe E',
        self::Alliance->value => 'Alliance',
        self::Regional->value => 'Regionale',
        self::National->value => 'Nationale',
    ];

    static function getName(string $type): string
    {
        return self::map[$type];
    }
}
