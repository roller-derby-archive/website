<?php

namespace App\Action\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArchiveAction extends AbstractController
{
    const ROUTE_NAME = 'archive';

    #[Route('/archive', name: self::ROUTE_NAME)]
    public function view(): Response
    {
        return $this->render('page/archive.html.twig');
    }
}
