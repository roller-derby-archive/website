<?php

declare(strict_types=1);

namespace App\Action;

use App\Flattrack\Gender;
use App\Repository\FlattrackRankingRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class FlattrackFrenchRankingAction extends AbstractController
{
    const ROUTE_NAME = 'flattrack_french_ranking';

    public function __construct(
        private readonly FlattrackRankingRepository $flattrackRankingRepository,
    ){}

    #[Route('/flattrackFrenchRanking/{gender}', name: 'flattrack_french_ranking')]
    public function flattrackFrenchRanking(Gender $gender): Response
    {
        $criteria = new Criteria();
        $criteria->orderBy(['europeanRank' => 'ASC']);
        $criteria->where(Criteria::expr()->eq('gender', $gender->value));
        $criteria->where(Criteria::expr()->isNull('team.disbandAt'));

        foreach ($this->flattrackRankingRepository->matching($criteria) as $flattrackRanking) {
            dd($flattrackRanking);
        }

        return $this->render('flattrack/french_ranking.html.twig', [
            "gender" => $gender,
            "data" => $this->flattrackRankingRepository->matching($criteria),
        ]);
    }
}
