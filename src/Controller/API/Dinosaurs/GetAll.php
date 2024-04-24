<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetAll extends AbstractController
{
    #[Route('/api/dinosaurs', methods: 'GET')]
    public function __invoke(ManagerRegistry $manager): Response
    {
        $dinosaurs = $manager
            ->getRepository(Dinosaur::class)
            ->findAll();

        $dinosaurs = array_map(fn (Dinosaur $dinosaur) => [
            'id'        => $dinosaur->getId(),
            'name'      => $dinosaur->getName(),
            'gender'    => $dinosaur->getGender(),
            'speciesId' => $dinosaur->getSpecies()->getId(),
            'age'       => $dinosaur->getAge(),
            'eyesColor' => $dinosaur->getEyesColor(),
        ], $dinosaurs);

        return new JsonResponse($dinosaurs);
    }
}
