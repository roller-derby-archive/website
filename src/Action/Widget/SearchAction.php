<?php

namespace App\Action\Widget;

use App\Repository\DBAL\SearchViewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class SearchAction extends AbstractController
{
    const ROUTE_NAME = 'widget_search';
    public function __construct(
        public readonly SearchViewRepository $searchViewRepository,
    ) {}

    #[Route('/widget/search', name: 'widget_search')]
    public function search(#[MapQueryParameter]string $needle = ''): Response
    {
        $results = $needle === '' ? null : $this->searchViewRepository->search($needle);

        return $this->render('widget/_search_bar.html.twig', [
            "needle" => $needle,
            "results" => $results,
        ]);
    }
}
