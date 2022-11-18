<?php

declare(strict_types=1);

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Hello extends AbstractController
{
    #[Route('/api/hello', methods: 'GET')]
    public function __invoke(): Response
    {
        return new JsonResponse([
            'message' => 'Hello world!'
        ]);
    }
}
