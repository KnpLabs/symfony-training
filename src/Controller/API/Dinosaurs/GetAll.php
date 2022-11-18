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

class GetAll extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    #[Route('/api/dinosaurs', methods: 'GET')]
    public function __invoke(ManagerRegistry $manager): Response
    {
        $dinosaurs = $manager
            ->getRepository(Dinosaur::class)
            ->findAll()
        ;

        $content = $this->serializer->serialize(
            $dinosaurs,
            'json',
            ['groups' => ['dinosaurs']]
        );

        return new JsonResponse($content, json: true);
    }
}
