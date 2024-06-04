<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ActivityController extends AbstractController
{
    #[Route('/activity', name: 'app_activity')]
    public function activity(): Response
    {
        return $this->render('activity.html.twig');
    }
}
