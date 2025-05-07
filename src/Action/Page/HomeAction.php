<?php

declare(strict_types=1);

namespace App\Action\Page;

use App\Repository\ChampionshipRepository;
use App\Repository\ClubRepository;
use App\Repository\EventRepository;
use App\Repository\GameRepository;
use App\Repository\TeamGameRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class HomeAction extends AbstractController
{
    const ROUTE_NAME = 'home';

    public function __construct(
        private readonly ClubRepository     $clubRepository,
        private readonly TeamRepository     $teamRepository,
        private readonly GameRepository     $gameRepository,
        private readonly TeamGameRepository $teamGameRepository,
        private readonly ChampionshipRepository $championshipRepository,
        private readonly EventRepository $eventRepository,
    ) {}

    #[Route('/', name: self::ROUTE_NAME)]
    public function view(Request $request): Response
    {
        return $this->render('page/home.html.twig', [
            'totalClubs' => $this->clubRepository->countAll(),
            'totalActiveClubs' => $this->clubRepository->countActive(),
            'totalTeams' => $this->teamRepository->countAll(),
            'totalActiveTeams' => $this->teamRepository->countActive(),
            'totalGames' => $this->gameRepository->countAll(),
            'totalHipsPassed' => $this->teamGameRepository->totalHipsPassed(),
            'totalEvents' => $this->eventRepository->countAll(),
            'totalChampionships' => $this->championshipRepository->countAll(),
        ]);
    }
}
