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
    private const QUERY_PARAM_FILTERS_SHOW_CLOSED = 'show_closed';
    private const FILTERS_SHOW_CLOSED_ONLY = 'only';

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

        return $this->render('club/list.html.twig', [
            'sortedClubs' => $sortedClubs,
            'total' => count($clubs),
        ]);
    }

    private function bindFilterByCriteria(Request $request, Criteria $criteria): void
    {
        $filters = $request->get('filters') ?? [];

        if (($filters[self::QUERY_PARAM_FILTERS_SHOW_CLOSED] ?? '') === self::FILTERS_SHOW_CLOSED_ONLY) {
            $criteria->andWhere(Criteria::expr()->isNotNull('closedAt'));
        } elseif (($filters[self::QUERY_PARAM_FILTERS_SHOW_CLOSED] ?? null) === null) {
            $criteria->andWhere(Criteria::expr()->eq('closedAt', null));
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
