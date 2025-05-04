<?php

namespace App\Action\Club;

use App\Entity\Club;
use App\Form\ClubType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class CreateAction extends AbstractController
{
    const ROUTE_NAME = 'club_create';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}
    #[Route('/clubs/create', name: self::ROUTE_NAME)]
    public function update(Request $request): Response
    {
        $club = new Club();

        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $club
                ->setId(Uuid::v4()->toString())
                ->setUpdatedAt(new \DateTimeImmutable())
            ;
            $this->entityManager->persist($club);
            $this->entityManager->flush();
            return $this->redirectToRoute(ViewAction::ROUTE_NAME, ['id' => $club->getId()]);
        }

        return $this->render('club/create.html.twig', [
            'form' => $form,
            'club' => $club,
        ]);
    }
}
