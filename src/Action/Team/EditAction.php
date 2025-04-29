<?php

namespace App\Action\Team;

use App\Entity\Club;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditAction extends AbstractController
{
    const ROUTE_NAME = 'team_edit';
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    #[Route('/teams/{id}/edit', name: self::ROUTE_NAME)]
    public function update(Request $request, Club $team): Response
    {
        $form = $this->createFormBuilder($team)
            ->add('name', TextType::class)
            ->add('disbandAt', DateTimeType::class, ['widget' => 'choice', 'format' => 'dd/MM/yyyy', 'label' => 'Date de dissolution'])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('team_view', ['id' => $team->getId()]);
        }

        return $this->render('club/edit.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }
}
