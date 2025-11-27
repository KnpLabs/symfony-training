<?php

namespace App\Controller\API;

use App\Entity\Species;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SpeciesController extends AbstractController
{
    #[Route('/api/species', methods: ['GET'])]
    public function list(Request $request, ManagerRegistry $doctrine): Response
    {
        $species = $doctrine->getRepository(Species::class)->findAll();
        $species = array_map(function (Species $species) {
            return [
                'id' => $species->getId(),
                'name' => $species->getName(),
                'habitats' => $species->getHabitats(),
                'feeding' => $species->getFeeding(),
            ];
        }, $species);

        return $this->json($species);
    }

    #[Route('/api/species', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $speciesData = json_decode($request->getContent(), true);

        $species = new Species(
            $speciesData['name'],
            $speciesData['habitats'],
            $speciesData['feeding']
        );

        $em = $doctrine->getManager();
        $em->persist($species);
        $em->flush();

        return $this->json([
            'id'        => $species->getId(),
            'name'      => $species->getName(),
            'habitats'  => $species->getHabitats(),
            'feeding'   => $species->getFeeding(),
        ], Response::HTTP_CREATED);
    }

    #[Route(
        '/api/species/{id}',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function remove(int $id, ManagerRegistry $doctrine): Response
    {
        $species = $doctrine
            ->getRepository(Species::class)
            ->find($id);

        if (false === $species) {
            return $this->json([
                'error' => 'The species you are looking for does not exists.'
            ], Response::HTTP_NOT_FOUND);
        }

        $em = $doctrine->getManager();
        $em->remove($species);
        $em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
