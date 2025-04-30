<?php

declare(strict_types=1);

namespace App\Action\Championship;

use App\Entity\Championship;
use App\Form\ChampionshipType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class ViewAction extends AbstractController
{
    const ROUTE_NAME = 'championship_view';

    #[Route('/championships/{id}', name: self::ROUTE_NAME)]
    public function create(Championship $championship): Response
    {
        return $this->render('championship/view.html.twig', [
            'championship' => $championship,
        ]);
    }
}
