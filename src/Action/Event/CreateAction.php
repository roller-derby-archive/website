<?php

namespace App\Action\Event;

use App\Entity\Event;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class CreateAction extends AbstractController
{
    const ROUTE_NAME = 'event_create';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}
    #[Route('/events/create', name: self::ROUTE_NAME)]
    public function update(Request $request): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event
                ->setId(Uuid::v4()->toString())
                ->setUpdatedAt(new \DateTimeImmutable())
            ;
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            return $this->redirectToRoute(ViewAction::ROUTE_NAME, ['id' => $event->getId()]);
        }

        return $this->render('event/create.html.twig', [
            'form' => $form,
            'event' => $event,
        ]);
    }
}
