<?php

declare(strict_types=1);

namespace App\App;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final readonly class Texts
{
    public static function getTexts(): array
    {
        return [
            'summary' => [
                'clubs' => 'Associations',
                'teams' => 'Équipes',
                'events' => 'Événements',
                'championships' => 'Championats',
                'rules' => 'L\'évolution des règles',
                'newClub' => 'Nouvelle asso? Par ici 👈',
                'rankingFPlus' => 'Classement Flattrack France F+',
                'rankingMixed' => 'Classement Flattrack France Mixte',
            ],
            'contact' => [
                'title' => 'Contact',
            ],
            'cgu' => [
                'title' => 'CGU',
            ],
            'about' => [
                'title' => 'A propos',
            ],
            'upgradeLogs' => [
                'title' => 'Journal des mises à jour',
            ],
        ];
    }
}
