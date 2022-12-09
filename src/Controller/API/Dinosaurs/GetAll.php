<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use App\Repository\DinosaurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetAll extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly DinosaurRepository $dinosaurs
    )
    {
    }

    #[Route('/api/dinosaurs', methods: 'GET')]
    #[OA\Tag('dinosaur')]
    #[OA\Parameter(
        parameter: 'page',
        name: 'page',
        schema: new OA\Schema(
            type: 'integer',
            default: 0,
            minimum: 0
        )
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
        parameter: 'filters',
        name: 'filters',
        in: 'query',
        schema: new OA\Schema(type: 'object'),
        example: '{"gender": "Male"}'
    )]
    #[OA\Parameter(
        parameter: 'sorts',
        name: 'sorts',
        in: 'query',
        schema: new OA\Schema(type: 'object'),
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
    public function __invoke(Request $request): Response
    {
        $dinosaurs = $this->dinosaurs
            ->search(
                filters: json_decode($request->query->get('filters')),
                sorts: json_decode($request->query->get('sorts')),
                page: $request->query->get('page'),
                limit: $request->query->get('limit')
            )
        ;

        $content = $this->serializer->serialize(
            $dinosaurs,
            'json',
            ['groups' => ['dinosaurs']]
        );

        return new JsonResponse(
            $content,
            json: true
        );
    }
}
