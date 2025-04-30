<?php

declare(strict_types=1);

namespace App\Action\Championship;

use App\Entity\Championship;
use App\Form\ChampionshipType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class CreateAction extends AbstractController
{
    const ROUTE_NAME = 'championship_create';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    #[Route('/championships/create', name: self::ROUTE_NAME)]
    public function create(Request $request): Response
    {
        $championship = new Championship();
        $form = $this->createForm(ChampionshipType::class, $championship);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $championship->setId(Uuid::v4()->toString());
            $this->entityManager->persist($championship);
            $this->entityManager->flush();
            return $this->redirectToRoute('championship_view', ['id' => $championship->getId()]);
        }

        return $this->render('championship/create.html.twig', [
            'form' => $form,
            'championship' => $championship,
        ]);
    }
}
