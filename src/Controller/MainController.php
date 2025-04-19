<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function view(): Response
    {
        return $this->render('main.html.twig');
    }
}
