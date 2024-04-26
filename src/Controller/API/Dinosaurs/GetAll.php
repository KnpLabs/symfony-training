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
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

final class GetAll extends AbstractController
{
    #[Route('/api/dinosaurs', methods: 'GET')]
    #[OA\Tag('dinosaur')]
    #[OA\Parameter(
        parameter: 'page',
        name: 'page',
        in: 'query',
        schema: new OA\Schema(
            type: 'integer',
            default: 1,
            minimum: 1
        ),
    )]
    #[OA\Parameter(
        parameter: 'limit',
        name: 'limit',
        in: 'query',
        schema: new OA\Schema(
            type: 'integer',
            default: 25,
            minimum: 1
        ),
    )]
    #[OA\Parameter(
        parameter: 'search',
        name: 'search',
        in: 'query',
        schema: new OA\Schema(type: 'string'),
        example: 'Dino'
    )]
    #[OA\Parameter(
        parameter: 'filters',
        name: 'filters',
        in: 'query',
        schema: new OA\Schema(type: 'object'),
        style: 'deepObject',
        explode: true,
        example: '{"name": "rex", "gender": "male"}',
    )]
    #[OA\Parameter(
        parameter: 'sorts',
        name: 'sorts',
        in: 'query',
        schema: new OA\Schema(type: 'object'),
        style: 'deepObject',
        explode: true,
        example: '{"age": "ASC"}'
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'List all the dinosaurs',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: new Model(
                    type: Dinosaur::class,
                    groups: ['dinosaurs']
                )
            )
        )
    )]
    public function __invoke(
        Request $request,
        SerializerInterface $serializer,
        ManagerRegistry $managerRegistry,
    ): Response {
        $filters = $request->query->all('filters') ?? [];
        $sorts = $request->query->all('sorts') ?? [];
        $search = $request->query->get('search');
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 5);

        $dinosaurs = $managerRegistry
            ->getRepository(Dinosaur::class)
            ->search($search)
            ->filter($filters)
            ->search($search)
            ->sort($sorts)
            ->paginate(
                $page,
                $limit
            );

        $content = $serializer->serialize(
            $dinosaurs,
            'json',
            ['groups' => ['dinosaurs']]
        );

        return new JsonResponse($content, json: true);
    }
}
