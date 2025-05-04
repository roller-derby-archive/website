<?php

namespace App\Action\Team;

use App\Entity\Team;
use App\Form\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EditAction extends AbstractController
{
    const ROUTE_NAME = 'team_edit';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    #[Route('/teams/{id}/edit', name: self::ROUTE_NAME)]
    public function update(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('team_view', ['id' => $team->getId()]);
        }

        return $this->render('team/edit.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }
}
