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

final class Create extends AbstractController
{
    #[Route('/api/dinosaurs', methods: 'POST')]
    public function __invoke(ManagerRegistry $manager, Request $request): Response
    {
        $dinosaurData = json_decode($request->getContent(), true);

        $species = $manager
            ->getRepository(Species::class)
            ->find($dinosaurData['speciesId']);

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

            return new JsonResponse([
                'id'        => $dinosaur->getId(),
                'name'      => $dinosaur->getName(),
                'gender'    => $dinosaur->getGender(),
                'speciesId' => $dinosaur->getSpecies()->getId(),
                'age'       => $dinosaur->getAge(),
                'eyesColor' => $dinosaur->getEyesColor(),
            ], Response::HTTP_CREATED);
        } catch (\Exception) {
            return new JsonResponse([
                'message' => 'Something went wrong'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
