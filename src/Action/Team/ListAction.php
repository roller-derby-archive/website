<?php

namespace App\Action\Team;

use App\Entity\Team;
use App\Helper\Common;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListAction extends AbstractController
{
    const ROUTE_NAME = 'team_list';
    private const QUERY_PARAM_FILTERS_CATEGORY = 'category';
    private const QUERY_PARAM_FILTERS_TYPE = 'type';
    private const QUERY_PARAM_FILTERS_LEVEL = 'level';
    private const QUERY_PARAM_FILTERS_ACTIVITY = 'activity';
    private const FILTERS_SHOW_CLOSED_DISBAND_ACTIVE = 'active';
    private const FILTERS_SHOW_CLOSED_DISBAND_INACTIVE = 'inactive';
    private const FILTERS_SHOW_CLOSED_DISBAND_BOTH = 'both';

    public function __construct(
        private readonly TeamRepository $teamRepository,
    ){}

    #[Route('/teams', name: self::ROUTE_NAME)]
    public function list(Request $request): Response
    {
        $criteria = new Criteria();
        $criteria->orderBy(["name" => "ASC"]);
        $this->bindFilterByCriteria($request, $criteria);
        // $this->bindOrderByCriteria($request, $criteria);

        $teams = $this->teamRepository->matching($criteria);
        $sortedTeams = [];

        /** @var Team $team */
        foreach ($teams as $team) {
            $sortedTeams[Common::GetFirstLetter($team->getName())][] = $team;
        }

        return $this->render('team/list.html.twig', [
            'sortedTeams' => $sortedTeams,
            'total' => count($teams),
            'filterForm' => [

            ],
        ]);
    }

    private function bindFilterByCriteria(Request $request, Criteria $criteria): void
    {
        $filters = $request->get('filters') ?? [];

       if (array_key_exists(self::QUERY_PARAM_FILTERS_CATEGORY, $filters)) {
           $criteria->andWhere(Criteria::expr()->in('category', $filters[self::QUERY_PARAM_FILTERS_CATEGORY]));
       }

       if (array_key_exists(self::QUERY_PARAM_FILTERS_TYPE, $filters)) {
           $criteria->andWhere(Criteria::expr()->in('type', $filters[self::QUERY_PARAM_FILTERS_TYPE]));
       }

       if (array_key_exists(self::QUERY_PARAM_FILTERS_LEVEL, $filters)) {
           $criteria->andWhere(Criteria::expr()->in('level', $filters[self::QUERY_PARAM_FILTERS_LEVEL]));
       }

       switch ($filters[self::QUERY_PARAM_FILTERS_ACTIVITY] ?? null) {
           // case self::FILTERS_SHOW_CLOSED_DISBAND_ACTIVE:
           case self::FILTERS_SHOW_CLOSED_DISBAND_INACTIVE:
               $criteria->andWhere(Criteria::expr()->isNotNull('disbandAt'));break;
           case self::FILTERS_SHOW_CLOSED_DISBAND_BOTH:break;
           default:
               $criteria->andWhere(Criteria::expr()->eq('disbandAt', null));break;
       }
    }
}
