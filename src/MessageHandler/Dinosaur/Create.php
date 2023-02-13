<?php

namespace App\MessageHandler\Dinosaur;

use App\Entity\Dinosaur;
use App\Entity\Park;
use App\Entity\Species;
use App\Message\Dinosaur\Create as CreateMessage;
use App\MessageResults\Dinosaur\Create as CreateMessageResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Create
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateMessage $message)
    {
        $speciesRepository = $this->entityManager->getRepository(Species::class);
        $parkRepository = $this->entityManager->getRepository(Park::class);

        if (!$species = $speciesRepository->find($message->speciesId)) {
            throw new NotFoundHttpException("Species with id {$message->speciesId} not found");
        }

        if (!$park = $parkRepository->find($message->parkId)) {
            throw new NotFoundHttpException("Park with id {$message->parkId} not found");
        }

        $dino = new Dinosaur(
            name: $message->name,
            gender: $message->gender,
            species: $species,
            age: $message->age,
            eyesColor: $message->eyesColor,
            park: $park
        );

        $this->entityManager->persist($dino);
        $this->entityManager->flush();

        return new CreateMessageResult($dino->getId());
    }
}
