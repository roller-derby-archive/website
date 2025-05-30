<?php

declare(strict_types=1);

namespace App\Action\Page;

use App\Repository\FlattrackRankingRepository;
use App\Scraper\Flattrack\Gender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class FlattrackRankingAction extends AbstractController
{
    const ROUTE_NAME = 'flattrack_french_ranking';

    public function __construct(
        private readonly FlattrackRankingRepository $flattrackRankingRepository,
    ){}

    #[Route('/flattrackFrenchRanking/{gender}', name: 'flattrack_french_ranking')]
    public function flattrackFrenchRanking(Gender $gender): Response
    {
        return $this->render('flattrack/french_ranking.html.twig', [
            "gender" => $gender,
            "frenchRanking" => $this->flattrackRankingRepository->findByGender($gender),
        ]);
    }
}
