<?php

declare(strict_types=1);

namespace App\Action\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class AboutAction extends AbstractController
{
    const ROUTE_NAME = 'about';

    #[Route('/about', name: self::ROUTE_NAME)]
    public function view(): Response
    {
        return $this->render('page/about.html.twig');
    }
}
