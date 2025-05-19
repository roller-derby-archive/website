<?php

declare(strict_types=1);

namespace App\Action\Dev;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class IntegrationSheetAction extends AbstractController
{
    #[Route('/dev/integrationSheet', name: 'dev_integration_sheet')]
    public function update(): Response
    {
        return $this->render('dev/integration_sheet.html.twig');
    }
}
