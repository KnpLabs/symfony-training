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

final class GetAll extends AbstractController
{
    #[Route('/api/dinosaurs', methods: 'GET')]
    public function __invoke(
        ManagerRegistry $manager,
        SerializerInterface $serializer
    ): Response {
        $dinosaurs = $manager
            ->getRepository(Dinosaur::class)
            ->findAll();

        $content = $serializer->serialize(
            $dinosaurs,
            'json',
            ['groups' => ['dinosaurs']]
        );

        return new JsonResponse($content, json: true);
    }
}
