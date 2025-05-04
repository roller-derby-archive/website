<?php

namespace App\EventListener;

use App\Action\Club;
use App\Action\Page\FlattrackRankingAction;
use App\Action\Team;
use App\Action\Widget\SearchAction;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

readonly class BeforeControllerListener implements EventSubscriberInterface
{
    public function __construct(
        private Environment $twig,
    ) {}

    public function onKernelController(ControllerEvent $event): void
    {
        $this->twig->addGlobal('themeName', $event->getRequest()->cookies->get('themeName', 'pink_city'));
        $this->twig->addGlobal('routes', [
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
            'page' => [
                'flattrackRanking' => FlattrackRankingAction::ROUTE_NAME,
            ],
            'widget' => [
                'search' => SearchAction::ROUTE_NAME,
            ],
        ]);
        $this->twig->addGlobal('styles', [
            'common' => [
                'link' => 'rda-link',
                'layout' => 'rda-layout',
                'main' => 'rda-main',
                'leftSideBar' => 'rda-left-side-bar',
                'titleBar' => 'rda-title-bar',
                'content' => 'rda-content',
                'rightSideBar' => 'rda-right-side-bar',
                'logoBox' => 'rda-logo-box',
            ],
            'page' => [
                'home' => [
                    'cell' => 'rda-page-home-cell',
                ],
            ],
            'template' => [
                'listWrapper' => 'rda-list-wrapper',
                'list' => 'rda-list',
            ]
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER => 'onKernelController'];
    }
}
