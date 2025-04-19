<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\FlattrackRanking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class PageController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){}

    #[Route('/', name: 'flattrack_french_ranking_women_and_more')]
    public function flattrackFrenchRankingWomenAndMore(): Response
    {
        return $this->render('page/flattrack_french_ranking.html.twig', [
            "gender" => 'women',
            "data" => $this->entityManager->getRepository(FlattrackRanking::class)->findWithRank('women'),
        ]);
    }

    #[Route('/mixte', name: 'flattrack_french_ranking_mix')]
    public function flattrackFrenchRankingMix(): Response
    {
        return $this->render('page/flattrack_french_ranking.html.twig', [
            "gender" => "men",
            "data" => $this->entityManager->getRepository(FlattrackRanking::class)->findWithRank('men'),
        ]);
    }
}
