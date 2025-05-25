<?php

namespace App\Action\Event;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditAction extends AbstractController
{
    const ROUTE_NAME = 'event_edit';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}
    #[Route('/events/{id}/edit', name: self::ROUTE_NAME)]
    public function update(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute(ViewAction::ROUTE_NAME, ['id' => $event->getId()]);
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form,
            'event' => $event,
        ]);
    }
}
