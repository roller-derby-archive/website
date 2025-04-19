<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Club;
use App\Enum\Region;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class ClubController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){}

    #[Route('/clubs', name: 'club_list')]
    public function list(): Response
    {
        $clubs = $this->entityManager->getRepository(Club::class)->findBy([], ['regionCode' => 'ASC', "name" => "ASC"]);
        $output = [];

        /** @var Club $club */
        foreach ($clubs as $club) {
            $output[Region::getName($club->getRegionCode())][] = $club;
        }

        return $this->render('club/list.html.twig', [
            'totalClub' => count($clubs),
            'regions' => $output,
        ]);
    }

    #[Route('/club/{id}', name: 'club_view')]
    public function view(Club $club): Response
    {
        return $this->render('club/view.html.twig', [
            'club' => $club,
        ]);
    }

//    #[Route('/club/{id}/edit', name: 'club_edit')]
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
