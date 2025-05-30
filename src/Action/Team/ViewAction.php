<?php

namespace App\Action\Team;

use App\App;
use App\Entity\Team;
use App\Repository\FlattrackRankingRepository;
use App\Scraper\Flattrack\EuropeanRankScraper;
use App\Scraper\Flattrack\Gender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class ViewAction extends AbstractController
{
    const ROUTE_NAME = 'team_view';

    public function __construct(
        private readonly FlattrackRankingRepository $flattrackRankingRepository,
        private readonly CacheInterface $cache,
        private readonly EuropeanRankScraper $europeanRankScraper,
    ){}
    #[Route('/teams/{id}', name: self::ROUTE_NAME)]
    public function view(Team $team): Response
    {
        $flattrackRank = [];
        $flattrackTotalClassedEuropeanTeam = 0;
        $flattrackTotalClassedFrenchTeam = 0;

        if ($team->getFlattrackId() !== null) {
            $gender = $team->getCategory() === "F+" ? Gender::Women : Gender::Men;

            $flattrackRank = $this->flattrackRankingRepository->find($team->getFlattrackId());
            $flattrackTotalClassedFrenchTeam =  count($this->flattrackRankingRepository->findBy(['gender' => $gender->value]));
            $cacheKey = "";
            switch ($gender) {
                case Gender::Women:
                    $cacheKey = App::CACHE_KEY_TOTAL_WOMEN_EUROPEAN_TEAM;break;
                case Gender::Men:
                    $cacheKey = App::CACHE_KEY_TOTAL_MEN_EUROPEAN_TEAM;break;
            }

            $flattrackTotalClassedEuropeanTeam = $this->cache->get($cacheKey, function (ItemInterface $item) use ($gender): int {
                $scrapedData = $this->europeanRankScraper->scrapRanks($gender);
                return $scrapedData['totalEuropeanRankedTeam'];
            });
        }

        return $this->render('team/view.html.twig', [
            'team' => $team,
            'gameBySeason' => $this->sortGamesBySeason($team),
            'flattrackRank' => $flattrackRank,
            'flattrackTotalClassedEuropeanTeam' => $flattrackTotalClassedEuropeanTeam,
            'flattrackTotalClassedFrenchTeam' => $flattrackTotalClassedFrenchTeam,
        ]);
    }

    private function sortGamesBySeason(Team $team): array
    {
        $gameBySeason = [];

        foreach ($team->getTeamGames() as $teamGame) {
            $season = '';
            $year = (int)$teamGame->getGame()->getPlayedAt()->format('Y');
            if ((int)$teamGame->getGame()->getPlayedAt()->format('m') > 7) {
                // start of season
                $season = sprintf('%s-%s', $year, $year+1);
            } else {
                $season = sprintf('%s-%s', $year-1, $year);
                // end of season
            }

            $gameBySeason[$season][] = $teamGame->getGame();
        }

        krsort($gameBySeason);

        return $gameBySeason;
    }
}
