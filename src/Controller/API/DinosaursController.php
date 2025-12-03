<?php

namespace App\Controller\API;

use App\Entity\Dinosaur;
use App\Entity\Species;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DinosaursController extends AbstractController
{
    #[Route('/api/dinosaurs', methods: ['GET'])]
    public function list(Request $request, ManagerRegistry $doctrine): Response
    {
        $dinosaurs = $doctrine->getRepository(Dinosaur::class)->findAll();

        $dinosaurs = array_map(function (Dinosaur $dinosaur) {
            return [
                'id' => $dinosaur->getId(),
                'name' => $dinosaur->getName(),
                'gender' => $dinosaur->getGender(),
                'speciesId' => $dinosaur->getSpecies()->getId(),
                'age' => $dinosaur->getAge(),
                'eyesColor' => $dinosaur->getEyesColor(),
                'createdBy' => $dinosaur->getCreatedBy()?->getEmail()
            ];
        }, $dinosaurs);

        return $this->json($dinosaurs);
    }

    #[Route(
        '/api/dinosaurs/{id}',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function single(string $id, ManagerRegistry $doctrine): Response
    {
        $dinosaur = $doctrine
            ->getRepository(Dinosaur::class)
            ->find($id);

        if (false === $dinosaur) {
            throw $this->createNotFoundException('The dinosaur you are looking for does not exists.');
        }

        $dinosaur = [
            'id' => $dinosaur->getId(),
            'name' => $dinosaur->getName(),
            'gender' => $dinosaur->getGender(),
            'speciesId' => $dinosaur->getSpecies()->getId(),
            'age' => $dinosaur->getAge(),
            'eyesColor' => $dinosaur->getEyesColor(),
            'createdBy' => $dinosaur->getCreatedBy()?->getEmail()
        ];

        return $this->json($dinosaur);
    }

    #[Route('/api/dinosaurs', methods: 'POST')]
    public function create(ManagerRegistry $manager, Request $request): Response
    {
        $dinosaurData = json_decode($request->getContent(), true);

        $species = $manager
            ->getRepository(Species::class)
            ->find($dinosaurData['speciesId']);

        if (!$species instanceof Species) {
            $this->json([
                'message' => sprintf('Species with id %s not found', $dinosaurData['speciesId']),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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

        return $this->json([
            'id'        => $dinosaur->getId(),
            'name'      => $dinosaur->getName(),
            'gender'    => $dinosaur->getGender(),
            'speciesId' => $dinosaur->getSpecies()->getId(),
            'age'       => $dinosaur->getAge(),
            'eyesColor' => $dinosaur->getEyesColor(),
            'createdBy' => $dinosaur->getCreatedBy()?->getEmail()
        ], Response::HTTP_CREATED);
    }

    #[Route('/api/dinosaurs/{id}', methods: 'DELETE')]
    public function delete(ManagerRegistry $manager, int $id): Response
    {
        $dinosaur = $manager
            ->getRepository(Dinosaur::class)
            ->find($id)
        ;

        if (!$dinosaur instanceof Dinosaur) {
            return $this->json([
                'message' => sprintf('Dinosaur with id %s not found', $id),
            ], Response::HTTP_NOT_FOUND);
        }

        $em = $manager->getManager();
        $em->remove($dinosaur);
        $em->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
