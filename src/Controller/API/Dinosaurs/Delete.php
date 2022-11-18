<?php

declare(strict_types=1);

namespace App\Controller\API\Dinosaurs;

use App\Entity\Dinosaur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    #[Route('/api/dinosaurs/{id}', methods: 'DELETE')]
    public function __invoke(ManagerRegistry $manager, string $id): Response
    {
        $dinosaur = $manager
            ->getRepository(Dinosaur::class)
            ->find($id)
        ;

        if (!$dinosaur instanceof Dinosaur) {
            return new JsonResponse([
                'message' => sprintf('Dinosaur with id %s not found', $id)
            ], Response::HTTP_NOT_FOUND);
        }

        $em = $manager->getManager();
        $em->remove($dinosaur);
        $em->flush();

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
