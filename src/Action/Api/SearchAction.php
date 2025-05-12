<?php

namespace App\Action\Api;

use App\Repository\DBAL\SearchViewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class SearchAction extends AbstractController
{
    const ROUTE_NAME = 'api_search';

    public function __construct(
        public readonly SearchViewRepository $searchViewRepository,
    ) {}

    #[Route('/api/search', name: self::ROUTE_NAME)]
    public function search(#[MapQueryParameter] string $needle = ''): Response
    {
        $results = $needle === '' ? [] : $this->searchViewRepository->search($needle);

        return new JsonResponse($results);
    }
}
