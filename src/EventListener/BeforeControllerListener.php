<?php

namespace App\EventListener;


use App\App\Routes;
use App\App\Styles;
use App\App\Texts;
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
        $this->twig->addGlobal('routes', Routes::getRoutes());
        $this->twig->addGlobal('styles', Styles::getStyles());
        $this->twig->addGlobal('texts', Texts::getTexts());
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER => 'onKernelController'];
    }
}
