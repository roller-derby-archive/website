<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Club;
use App\Entity\FlattrackRanking;
use App\Entity\Team;
use App\Enum\Region;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class TeamController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){}

//    #[Route('/teams', name: 'team_list')]
    public function list(): Response
    {
        $teams = $this->entityManager->getRepository(Team::class)->findBy([], ['name' => 'ASC']);
        $output = [];

        /** @var Team $team */
        foreach ($teams as $team) {
            $letter = substr($team->getName(), 0, 1);
            if (!preg_match('/[A-Z]/', $letter)) {
                $letter = substr($team->getName(), 0, 2);
                mb_convert_encoding($letter, 'ISO-8859-1', 'UTF-8');

                if ($letter === "É") {
                    $letter = 'E';
                }
            }

            $output[$letter][] = $team;
        }

        return $this->render('team/list.html.twig', [
            'totalTeam' => count($teams),
            'regions' => $output,
        ]);
    }

    #[Route('/teams/{id}', name: 'team_view')]
    public function view(Team $team): Response
    {
        $flattrackRank = [];
        $flattrackTotalClassedEuropeanTeam = 0;
        $flattrackTotalClassedFrenchTeam = 0;

        if ($team->getFlattrackId() !== null) {
            $category = $team->getGenderScope() === "F+" ? "women" : "men";

            $flattrackRank = $this->entityManager->getRepository(FlattrackRanking::class)->findOneWithRank($team->getFlattrackId(), $category);
            $flattrackTotalClassedFrenchTeam = $this->entityManager->getRepository(FlattrackRanking::class)->totalRows($category);

            if ($category == "women") {
                $flattrackTotalClassedEuropeanTeam = file_get_contents(__DIR__.'/../../var/data/total_women_european_team_number');
            } else {
               $flattrackTotalClassedEuropeanTeam = file_get_contents(__DIR__.'/../../var/data/total_men_european_team_number');
            }
        }

        return $this->render('team/view.html.twig', [
            'team' => $team,
            'flattrackRank' => $flattrackRank,
            'flattrackTotalClassedEuropeanTeam' => $flattrackTotalClassedEuropeanTeam,
            'flattrackTotalClassedFrenchTeam' => $flattrackTotalClassedFrenchTeam,
        ]);
    }
}
