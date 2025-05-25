<?php

declare(strict_types=1);

namespace App\App;

use App\Action\Api\SearchAction;
use App\Action\Club;
use App\Action\Event;
use App\Action\Page\AboutAction;
use App\Action\Page\CguAction;
use App\Action\Page\ContactAction;
use App\Action\Page\FlattrackRankingAction;
use App\Action\Page\HomeAction;
use App\Action\Page\LegalAction;
use App\Action\Page\UpgradeLogsAction;
use App\Action\Team;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final readonly class Routes
{
    public static function getRoutes(): array
     {
        return [
            'club' => [
                'view' => Club\ViewAction::ROUTE_NAME,
                'list' => Club\ListAction::ROUTE_NAME,
                'edit' => Club\EditAction::ROUTE_NAME,
                'create' => Club\CreateAction::ROUTE_NAME,
            ],
            'team' => [
                'view' => Team\ViewAction::ROUTE_NAME,
                'list' => Team\ListAction::ROUTE_NAME,
                'edit' => Team\EditAction::ROUTE_NAME,
                'create' => Team\CreateAction::ROUTE_NAME,
            ],
            'game' => [ // TODO
                'view' => Team\ViewAction::ROUTE_NAME,
            ],
            'event' => [ // TODO
                'view' => Event\ViewAction::ROUTE_NAME,
                'list' => Event\ListAction::ROUTE_NAME,
                'edit' => Event\EditAction::ROUTE_NAME,
                'create' => Event\CreateAction::ROUTE_NAME,
            ],
            'championship' => [ // TODO
                'view' => Team\ViewAction::ROUTE_NAME,
                'list' => Team\ListAction::ROUTE_NAME,
                'edit' => Team\EditAction::ROUTE_NAME,
                'create' => Team\CreateAction::ROUTE_NAME,
            ],
            'page' => [
                'home' => HomeAction::ROUTE_NAME,
                'flattrackRanking' => FlattrackRankingAction::ROUTE_NAME,
                'about' => AboutAction::ROUTE_NAME,
                'contact' => ContactAction::ROUTE_NAME,
                'cgu' => CguAction::ROUTE_NAME,
                'upgradeLogs' => UpgradeLogsAction::ROUTE_NAME,
            ],
            'widget' => [
                'search' => SearchAction::ROUTE_NAME,
            ],
        ];
     }
}
