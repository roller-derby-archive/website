<?php

namespace App\Action\Club;

use App\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ViewAction extends AbstractController
{
    const ROUTE_NAME = 'club_view';
    #[Route('/club/{id}', name: self::ROUTE_NAME)]
    public function view(Club $club): Response
    {
        return $this->render('club/view.html.twig', [
            'club' => $club,
        ]);
    }
}
