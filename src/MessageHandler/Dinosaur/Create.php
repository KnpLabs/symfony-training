<?php

namespace App\MessageHandler\Dinosaur;

use App\Entity\Dinosaur;
use App\Entity\Species;
use App\Message\Dinosaur\Create as CreateMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class Create implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateMessage $message): void
    {
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        if (!$species = $speciesRepository->find($message->speciesId)) {
            throw new NotFoundHttpException("Species with id {$message->speciesId} not found");
        }

        $dino = new Dinosaur(
            name: $message->name,
            gender: $message->gender,
            species: $species,
            age: $message->age,
            eyesColor: $message->eyesColor
        );

        $this->entityManager->persist($dino);
        $this->entityManager->flush();
    }
}
