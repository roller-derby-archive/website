<?php

namespace App\Action\Game;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ViewAction extends AbstractController
{
    const ROUTE_NAME = 'game_view';
    #[Route('/games/{id}', name: self::ROUTE_NAME)]
    public function view(Game $game): Response
    {
        return $this->render('game/view.html.twig', [
            'game' => $game,
        ]);
    }
}
