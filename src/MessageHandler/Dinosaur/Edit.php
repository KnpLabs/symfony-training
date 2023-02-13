<?php

namespace App\MessageHandler\Dinosaur;

use App\Entity\Dinosaur;
use App\Entity\Species;
use App\Message\Dinosaur\Edit as EditMessage;
use App\MessageResults\Dinosaur\Edit as EditOutput;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Edit
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(EditMessage $message)
    {
        $dinosaurRepository = $this->entityManager->getRepository(Dinosaur::class);
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        if (!$dinosaur = $dinosaurRepository->find($message->id)) {
            throw new NotFoundHttpException("Dinosaur with id {$message->id} not found");
        }

        if (!$species = $speciesRepository->find($message->speciesId)) {
            throw new NotFoundHttpException("Species with id {$message->id} not found");
        }

        $dinosaur->setName($message->name);
        $dinosaur->setEyesColor($message->eyesColor);
        $dinosaur->setAge($message->age);
        $dinosaur->setSpecies($species);

        $this->entityManager->flush();
    }
}
