<?php

namespace App\Action\Team;

use App\Entity\Team;
use App\Enum\Country;
use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

final class CreateAction extends AbstractController
{
    const ROUTE_NAME = 'team_create';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    #[Route('/teams/create', name: self::ROUTE_NAME)]
    public function create(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team->setId(Uuid::v4()->toString());
            $team->setUpdatedAt((new \DateTimeImmutable())->setTime(0, 0));
            $team->setCountryCode(Country::FRANCE->value);
            $this->entityManager->persist($team);
            $this->entityManager->flush();
            return $this->redirectToRoute('team_view', ['id' => $team->getId()]);
        }

        return $this->render('team/create.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }
}
