<?php

declare(strict_types=1);

namespace App\Action;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Form\Type\VichImageType;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class TestAction extends AbstractController
{
    const ROUTE_NAME = 'test_view';

    #[Route('/test', name: self::ROUTE_NAME)]
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        $team = new Team();
        $team->setId(Uuid::v4()->toString());
        $team->setCreatedAt(new \DateTimeImmutable());
        $team->setUpdatedAt(new \DateTimeImmutable());
        $team->setCategory('F+');
        $team->setCountryCode('OTHER');
        $team->setType('A');
        $form = $this->createFormBuilder($team)
            ->add('name', TextType::class)
            ->add('logoFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => '...',
                'download_label' => '...',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            $entityManager->persist($team);
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('test_2');
        }

        return $this->render('test.html.twig', [
            "form" => $form,
        ]);
    }

    #[Route('/testview/{team}', name: 'test_2')]
    public function view(Team $team): Response
    {
        return $this->render('test_view.html.twig', ['team' => $team]);
    }
}
