<?php

namespace App\Action\Club;

use App\Entity\Club;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditAction extends AbstractController
{
    const ROUTE_NAME = 'club_edit';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}
    #[Route('/club/{id}/edit', name: self::ROUTE_NAME)]
    public function update(Request $request, Club $club): Response
    {
        $form = $this->createFormBuilder($club)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('club_view', ['id' => $club->getId()]);
        }

        return $this->render('club/edit.html.twig', [
            'form' => $form,
            'club' => $club,
        ]);
    }
}
