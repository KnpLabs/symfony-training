<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Discovery;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    #[Route('/activity', name: 'app_activity')]
    public function activity(): Response
    {
        return $this->render('activity.html.twig');
    }

    #[Route('/api/activity', name: 'api_activity')]
    public function apiActivity(Request $request, Discovery $discovery): Response
    {
        $discovery->addLink($request);

        return new JsonResponse([
            'topic' => 'https://dinosaur-app/activity'
        ]);
    }
}
