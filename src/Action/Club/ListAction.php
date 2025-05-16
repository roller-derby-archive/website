<?php

namespace App\Action\Club;

use App\Entity\Club;
use App\Enum\Region;
use App\Helper\Common;
use App\Repository\ClubRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListAction extends AbstractController
{
    const ROUTE_NAME = 'club_list';
    private const QUERY_PARAM_SORT_VIEW = 'sort_view';
    private const SORT_VIEW_REGION = 'region';
    private const SORT_VIEW_ALPHANUMERIC = 'alpha';
    private const SORT_VIEW_DEFAULT_VALUE = self::SORT_VIEW_REGION;
    private const QUERY_PARAM_FILTERS_ACTIVITY = 'activity';
    private const FILTERS_SHOW_CLOSED_DISBAND_ACTIVE = 'active';
    private const FILTERS_SHOW_CLOSED_DISBAND_INACTIVE = 'inactive';
    private const FILTERS_SHOW_CLOSED_DISBAND_BOTH = 'both';
    public function __construct(
        private readonly ClubRepository $clubRepository,
    ){}

    #[Route('/clubs', name: self::ROUTE_NAME)]
    public function list(Request $request): Response
    {
        $criteria = new Criteria();
        $this->bindFilterByCriteria($request, $criteria);
        $this->bindOrderByCriteria($request, $criteria);

        $clubs = $this->clubRepository->matching($criteria);
        $sortedClubs = [];

        /** @var Club $club */
        foreach ($clubs as $club) {
            switch ($request->get(self::QUERY_PARAM_SORT_VIEW) ?? self::SORT_VIEW_DEFAULT_VALUE) {
                case self::SORT_VIEW_REGION:
                    $sortedClubs[Region::getName($club->getRegionCode())][] = $club;
                    break;
                case self::SORT_VIEW_ALPHANUMERIC:
                    $sortedClubs[Common::GetFirstLetter($club->getName())][] = $club;
                    break;
            }
        }

        // Club + titles
        $totalListRows = count($clubs) + count($sortedClubs);
        $columnLimit = round($totalListRows / 2);
        $interlineCounter = 0;
        $interline = 0;
        $firstColumnRows = 0;
        $lastFirstColumnRows = 0;
        $voidIndex = 0;
        $voidSpaces = 0;
        $lastIndex = '';

        foreach ($sortedClubs as $index => $sortedClub) {
            if ($columnLimit < $firstColumnRows) {
                $voidIndex = $lastIndex;
                $voidSpaces = $columnLimit - $lastFirstColumnRows + $interline;

                break;
            }

            $interlineCounter ++;
            if ($interlineCounter > 2) {
                $interlineCounter = 0;
                $interline ++;
            }

            $lastFirstColumnRows = $firstColumnRows;
            $firstColumnRows += 1 + count($sortedClub);
            $lastIndex = $index;
        }

        // dd('totalListRows', $totalListRows, 'columnLimit', $columnLimit, 'firstColumnRows', $firstColumnRows, 'voidIndex', $voidIndex, 'voidSpaces', $voidSpaces);

        return $this->render('club/list.html.twig', [
            'sortedClubs' => $sortedClubs,
            'total' => count($clubs),
            'voidIndex' => $voidIndex,
            'voidSpaces' => $voidSpaces,
        ]);
    }

    private function bindFilterByCriteria(Request $request, Criteria $criteria): void
    {
        $filters = $request->get('filters') ?? [];

        switch ($filters[self::QUERY_PARAM_FILTERS_ACTIVITY] ?? null) {
            // case self::FILTERS_SHOW_CLOSED_DISBAND_ACTIVE:
            case self::FILTERS_SHOW_CLOSED_DISBAND_INACTIVE:
                $criteria->andWhere(Criteria::expr()->isNotNull('closedAt'));break;
            case self::FILTERS_SHOW_CLOSED_DISBAND_BOTH:break;
            default:
                $criteria->andWhere(Criteria::expr()->eq('closedAt', null));break;

        }
    }

    private function bindOrderByCriteria(Request $request, Criteria $criteria): void
    {
        $sortView = $request->get(self::QUERY_PARAM_SORT_VIEW) ?? self::SORT_VIEW_DEFAULT_VALUE;

        $orderBy = [];
        switch ($sortView) {
            case self::SORT_VIEW_REGION:
                $orderBy = ['regionCode' => 'ASC', "name" => "ASC"];
                break;
            case self::SORT_VIEW_ALPHANUMERIC:
                $orderBy = ["name" => "ASC"];
                break;
        }

        $criteria->orderBy($orderBy);
    }
}
