<?php

namespace App\Twig;

use App\Enum\Region;
use App\Flattrack\Flattrack;
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
        return Flattrack::GetTeamsPath($teamId);
    }
}
