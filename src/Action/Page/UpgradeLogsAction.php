<?php

declare(strict_types=1);

namespace App\Action\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class UpgradeLogsAction extends AbstractController
{
    const ROUTE_NAME = 'upgrade_logs';

    #[Route('/upgradeLogs', name: self::ROUTE_NAME)]
    public function view(): Response
    {
        return $this->render('page/upgrade_logs.html.twig');
    }
}
