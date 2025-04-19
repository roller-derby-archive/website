<?php

declare(strict_types=1);

namespace App\Twig;

use App\Enum\County;
use App\Enum\Region;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class LocalisationExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('region', [$this, 'getRegion']),
            new TwigFunction('county', [$this, 'getCounty']),
        ];
    }

    public function getRegion(string $regionCode): string
    {
        return Region::getName($regionCode);
    }
    public function getCounty(string $countyCode): string
    {
        return County::getName($countyCode);
    }

}
