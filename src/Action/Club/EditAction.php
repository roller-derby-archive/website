<?php

namespace App\Action\Club;

use App\Entity\Club;
use App\Form\ClubType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditAction extends AbstractController
{
    const ROUTE_NAME = 'club_edit';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}
    #[Route('/clubs/{id}/edit', name: self::ROUTE_NAME)]
    public function update(Request $request, Club $club): Response
    {
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute(ViewAction::ROUTE_NAME, ['id' => $club->getId()]);
        }

        return $this->render('club/edit.html.twig', [
            'form' => $form,
            'club' => $club,
        ]);
    }
}
