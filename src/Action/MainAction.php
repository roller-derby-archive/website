<?php

declare(strict_types=1);

namespace App\Action;

use App\Repository\ClubRepository;
use App\Repository\GameRepository;
use App\Repository\GameTeamRepository;
use App\Repository\TeamGameRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class MainAction extends AbstractController
{
    const ROUTE_NAME = 'main';

    public function __construct(
        private readonly ClubRepository     $clubRepository,
        private readonly TeamRepository     $teamRepository,
        private readonly GameRepository     $gameRepository,
        private readonly TeamGameRepository $teamGameRepository,
    ) {}

    #[Route('/', name: self::ROUTE_NAME)]
    public function view(): Response
    {
        return $this->render('main.html.twig', [
            'totalClubs' => $this->clubRepository->countAll(),
            'totalActiveClubs' => $this->clubRepository->countActive(),
            'totalTeams' => $this->teamRepository->countAll(),
            'totalActiveTeams' => $this->teamRepository->countActive(),
            'totalGames' => $this->gameRepository->countAll(),
            'totalHipsPassed' => $this->teamGameRepository->totalHipsPassed(),
        ]);
    }
}
