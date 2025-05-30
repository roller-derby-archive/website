<?php

namespace App\Twig;

use App\Scraper\Flattrack\Flattrack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FlattrackExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('flattrackTeamPath', [$this, 'getFlattrackTeamPath']),
        ];
    }

    public function getFlattrackTeamPath(string $teamId): string
    {
        return Flattrack::GetTeamPath($teamId);
    }
}
