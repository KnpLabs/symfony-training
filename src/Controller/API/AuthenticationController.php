<?php

declare(strict_types=1);

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AuthenticationController extends AbstractController
{
    #[Route('/api/authenticate', methods: ['POST'])]
    public function authenticate(): Response
    {
        // to complete

        return $this->json([
            'error' => 'Not implemented yet'
        ], Response::HTTP_NOT_IMPLEMENTED);
    }
}
