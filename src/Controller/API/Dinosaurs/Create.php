<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use App\Entity\Species;
use App\Validation\JsonSchema\Object\Dinosaur\CreateSchema;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use KnpLabs\JsonSchema\Validator;
use KnpLabs\JsonSchemaBundle\Exception\JsonSchemaException;
use KnpLabs\JsonSchemaBundle\OpenApi\Attributes\JsonContent;
use KnpLabs\JsonSchemaBundle\RequestHandler;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Create extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly Validator $validator,
        private readonly RequestHandler $requestHandler
    )
    {
    }

    #[Route('/api/dinosaurs', methods: 'POST')]
    #[OA\Tag('dinosaur')]
    #[OA\RequestBody(
        required: true,
        content: new JsonContent(CreateSchema::class)
    )]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Create and return a dinosaur',
        content: new Model(type: Dinosaur::class, groups: ['dinosaur'])
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Bad request'
    )]
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'The species ID does not exists'
    )]
    public function __invoke(ManagerRegistry $manager, Request $request): Response
    {
        try {
            $dinosaurData = $this->requestHandler->extractJson($request, CreateSchema::class);
        } catch (JsonSchemaException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST, json: true);
        }

        $species = $manager
            ->getRepository(Species::class)
            ->find($dinosaurData['speciesId'])
        ;

        if (!$species instanceof Species) {
            return new JsonResponse([
                'message' => sprintf('Species with id %s not found', $dinosaurData['speciesId']),
                Response::HTTP_UNPROCESSABLE_ENTITY
            ]);
        }

        try {
            $dinosaur = new Dinosaur(
                $dinosaurData['name'],
                $dinosaurData['gender'],
                $species,
                $dinosaurData['age'],
                $dinosaurData['eyesColor'],
            );

            $em = $manager->getManager();
            $em->persist($dinosaur);
            $em->flush();

            $content = $this->serializer->serialize(
                $dinosaur,
                'json',
                ['groups' => ['dinosaur']]
            );

            return new JsonResponse($content, Response::HTTP_CREATED, json: true);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
