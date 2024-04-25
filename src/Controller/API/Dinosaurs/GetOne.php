<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class GetOne extends AbstractController
{
    #[Route('/api/dinosaurs/{id}', methods: 'GET')]
    public function __invoke(
        ManagerRegistry $manager,
        SerializerInterface $serializer,
        string $id
    ): Response {
        $dinosaur = $manager
            ->getRepository(Dinosaur::class)
            ->find($id);

        if (!$dinosaur instanceof Dinosaur) {
            return new JsonResponse([
                'message' => sprintf('Dinosaur with id %s not found.', $id)
            ], Response::HTTP_NOT_FOUND);
        }

        $content = $serializer->serialize(
            $dinosaur,
            'json',
            ['groups' => ['dinosaur']]
        );

        return new JsonResponse($content, json: true);
    }
}
