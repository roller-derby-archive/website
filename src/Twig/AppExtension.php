<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('facebookUglyId', [$this, 'facebookUglyId']),
        ];
    }

    public function facebookUglyId(string $id): string
    {
        if (preg_match('/^profile\.php\?id=(\d+)$/', $id)) {
            return 'page';
        }

        return $id;
    }
}
