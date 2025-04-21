<?php

declare(strict_types=1);

namespace App\Twig;

use App\Enum\TeamCategory;
use App\Enum\TeamType;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class TeamExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('teamName', [$this, 'getName']),
            new TwigFunction('teamCategory', [$this, 'getCategory']),
            new TwigFunction('teamType', [$this, 'GetType']),
        ];
    }

    public function getName(string $name, ?string $pronoun): string
    {
        $prefix = "";

        if ($pronoun !== null) {
            if ($pronoun === "L'") {
                $prefix = "L'";
            } else {
                $prefix = $pronoun.' ';
            }
        }

        return $prefix.$name;
    }

    public function getCategory(string $category): string
    {
        return TeamCategory::getName($category);
    }
    public function GetType(string $type): string
    {
        return TeamType::getName($type);
    }
}
