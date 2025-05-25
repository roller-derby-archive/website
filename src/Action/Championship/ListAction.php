<?php

namespace App\Action\Championship;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListAction extends AbstractController
{
    const ROUTE_NAME = 'championship_list';

    #[Route('/championships', name: self::ROUTE_NAME)]
    public function list(Request $request): Response
    {
        return $this->render('championship/list.html.twig', [
        ]);
    }
}
