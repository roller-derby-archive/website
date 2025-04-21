<?php

declare(strict_types=1);

namespace App\Twig;

use App\Enum\ClubGenderDiversityPolicy;
use App\Enum\TeamCategory;
use App\Enum\TeamType;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class ClubExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('genderDiversityPolicyName', [$this, 'getGenderDiversityPolicyName']),
        ];
    }

    public function getGenderDiversityPolicyName(string $name): string
    {
        return ClubGenderDiversityPolicy::getName($name);
    }
}
