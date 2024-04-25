<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use App\Entity\Species;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Validator\JsonSchema\Validator as JsonSchemaValidator;
use App\Validator\JsonSchema\ValidationException as JsonSchemaValidationException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

final class Create extends AbstractController
{
    #[Route('/api/dinosaurs', methods: 'POST')]
    #[OA\Tag('dinosaur')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            schema: "DinosaurCreate",
            title: "Dinosaur create",
            description: "Input data for creating a new dinosaur",
            required: ["name", "gender", "speciesId", "age", "eyesColor"],
            properties: [
                new OA\Property(
                    property: "name",
                    type: "string",
                    description: "Name of the dinosaur",
                    minLength: 1,
                    maxLength: 255,
                    example: 'Rex'
                ),
                new OA\Property(
                    property: "gender",
                    type: "string",
                    enum: ["Male", "Female"],
                    description: "Gender of the dinosaur",
                    example: "Male"
                ),
                new OA\Property(
                    property: "speciesId",
                    type: "integer",
                    description: "ID of the species",
                    example: 1
                ),
                new OA\Property(
                    property: "age",
                    type: "integer",
                    description: "Age of the dinosaur",
                    exclusiveMinimum: 0,
                    example: 10
                ),
                new OA\Property(
                    property: "eyesColor",
                    type: "string",
                    description: "Color of the eyes",
                    minLength: 1,
                    maxLength: 255,
                    example: 'red'
                )
            ]
        )
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
    public function __invoke(
        ManagerRegistry $manager,
        Request $request,
        SerializerInterface $serializer,
        JsonSchemaValidator $jsonSchemaValidator
    ): Response {
        try {
            $jsonSchemaValidator->validate($request, '/dinosaur/create.json');
        } catch (JsonSchemaValidationException $e) {
            return new JsonResponse(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST,
                json: true
            );
        }

        $dinosaurData = json_decode($request->getContent(), true);

        $species = $manager
            ->getRepository(Species::class)
            ->find($dinosaurData['speciesId']);

        if (!$species instanceof Species) {
            return new JsonResponse([
                'message' => sprintf('Species with id %s not found', $dinosaurData['speciesId']),
                Response::HTTP_UNPROCESSABLE_ENTITY
            ]);
        }

        $dinosaurData = json_decode($request->getContent(), true);

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

            $content = $serializer->serialize(
                $dinosaur,
                'json',
                ['groups' => ['dinosaur']]
            );

            return new JsonResponse(
                $content,
                Response::HTTP_CREATED,
                json: true
            );
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ], Response::HTTP_CREATED);
        }
    }
}
