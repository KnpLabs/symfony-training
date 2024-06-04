<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use App\Repository\DinosaurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

final class GetOne extends AbstractController
{
    #[Route('/api/dinosaurs/{id}', methods: 'GET')]
    #[OA\Tag('dinosaur')]
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Dinosaur with given ID not found'
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Specified dinosaur',
        content: new Model(type: Dinosaur::class, groups: ['dinosaur'])
    )]
    public function __invoke(
        DinosaurRepository $dinosaurRepository,
        SerializerInterface $serializer,
        string $id
    ): Response {
        $dinosaur = $dinosaurRepository->find($id);

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