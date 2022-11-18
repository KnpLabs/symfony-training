<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use App\Entity\Species;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Create extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    #[Route('/api/dinosaurs', methods: 'POST')]
    public function __invoke(ManagerRegistry $manager, Request $request): Response
    {
        $dinosaurData = json_decode($request->getContent(), true);

        $species = $manager
            ->getRepository(Species::class)
            ->find($dinosaurData['speciesId'])
        ;

        if (!$species instanceof Species) {
            return new JsonResponse([
                'message' => sprintf('Species with id %s not found', $dinosaurData['speciesId']),
                Response::HTTP_NOT_FOUND
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
