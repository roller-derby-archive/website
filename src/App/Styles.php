<?php

declare(strict_types=1);

namespace App\App;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final readonly class Styles
{
    public static function getStyles(): array
    {
        return [
            'common' => [
                'link' => 'rda-link',
                'layout' => 'rda-layout',
                'main' => 'rda-main',
                'leftSideBar' => 'rda-left-side-bar',
                'titleBar' => 'rda-title-bar',
                'content' => 'rda-content',
                'rightSideBar' => 'rda-right-side-bar',
                'logoBox' => 'rda-logo-box',
                'flag' => 'rda-flag',
                'siteLogo' => 'rda-site-logo',
                'searchResultClub' => 'rda-search-result-club',
                'searchResultTeam' => 'rda-search-result-team',
            ],
            'page' => [
                'home' => [
                    'cell' => 'rda-page-home-cell',
                ],
            ],
            'template' => [
                'listWrapper' => 'rda-list-wrapper',
                'list' => 'rda-list',
            ],
            'team' => [
                'category' => 'rda-team-category',
                'level' => 'rda-team-level',
                'type' => 'rda-team-type',
            ],
            'form' => [
                'applyInput' => 'rda-apply-input',
                'resetInput' => 'rda-reset-input',
                'submit' => 'rda-submit',
            ],
            'edit' => [
                'section' => 'rda-edit-section',
                'sectionVisible' => 'rda-edit-section-visible',
            ],
            'infobox' => [
                'main' => 'rda-infobox',
            ],
            'ftfr' => [
                'table' => 'rda-ftfr-table',
                'rankCell' => 'rda-ftfr-rank-cell',
                'logoCell' => 'rda-ftfr-logo-cell',
                'nameCell' => 'rda-ftfr-name-cell',
                'otherCell' => 'rda-ftfr-other-cell',
            ],
            'wiki' => [
                'link' => 'rda-wiki-link',
            ],
            'games' => [
                'list' => 'rda-games-list',
            ],
            'club' => [
                'viewContent' => 'rda-club-view-content',
            ],
        ];
    }
}
