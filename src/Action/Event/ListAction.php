<?php

namespace App\Action\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListAction extends AbstractController
{
    const ROUTE_NAME = 'event_list';

    #[Route('/events', name: self::ROUTE_NAME)]
    public function list(Request $request): Response
    {
        return $this->render('event/list.html.twig', [
        ]);
    }
}
