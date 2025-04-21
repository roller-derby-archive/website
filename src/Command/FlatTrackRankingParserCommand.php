<?php

declare(strict_types=1);

namespace App\Command;

use App\App;
use App\Entity\FlattrackRanking;
use App\Flattrack\EuropeanRankScraper;
use App\Flattrack\Gender;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
#[AsCommand(name: 'flattrack:refresh-ranking')]
final class FlatTrackRankingParserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EuropeanRankScraper $europeanRankScraper,
        private readonly CacheInterface $cache,
        ?string $name = null)
    {
        parent::__construct($name);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->entityManager->getRepository(FlattrackRanking::class)->cleanAll();
        $this->regenerateRanking(Gender::Women);
        $this->regenerateRanking(Gender::Men);

        return Command::SUCCESS;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws InvalidArgumentException
     */
    private function regenerateRanking(Gender $gender): void
    {
        $cacheKey = "";
        switch ($gender) {
            case Gender::Women:
                $cacheKey = App::CACHE_KEY_TOTAL_WOMEN_EUROPEAN_TEAM;break;
            case Gender::Men:
                $cacheKey = App::CACHE_KEY_TOTAL_MEN_EUROPEAN_TEAM;break;
        }

        $scrapedData = $this->europeanRankScraper->scrapRanks($gender);
        // Set cache value
        $this->cache->get($cacheKey, function (ItemInterface $item) use ($scrapedData) : int {
            return $scrapedData['totalEuropeanRankedTeam'];
        });

        $i = 1;
        foreach ($scrapedData['rankedTeams'] as $key => $content) {
            extract($content); // $teamId, $europeanRank, $rating

            // Check if flattrack team id exist because we persist only french team rank.
            if (!$this->entityManager->getRepository(FlattrackRanking::class)->checkId((int)$teamId)) {
                continue;
            }

            $rank = new FlattrackRanking();
            $rank->setId((int)$teamId);
            $rank->setEuropeanRank((int)$europeanRank);
            $rank->setRating($rating);
            $rank->setGender($gender->value);
            $rank->setFrenchRank($i);

            $this->entityManager->persist($rank);
            $i++;
        }

        $this->entityManager->flush();
    }
}
