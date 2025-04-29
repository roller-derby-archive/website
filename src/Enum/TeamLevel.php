<?php

declare(strict_types=1);

namespace App\Enum;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
enum TeamLevel: string
{
    case Casual = 'Loisir';
    case NationalThree = 'N3';
    case NationalTwo = 'N2';
    case NationalOne = 'N1';
    case Elite = 'Élite';
}
