<?php

namespace App\MessageHandler;

use App\Entity\Dinosaur;
use App\Entity\Species;
use App\Message\CreateDinosaur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateDinosaurHandler implements MessageHandlerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(CreateDinosaur $message): void
    {
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        if (!$species = $speciesRepository->find($message->getSpeciesId())) {
            throw new NotFoundHttpException("Species with id {$message->getSpeciesId()} not found");
        }

        $dino = new Dinosaur(
            name: $message->getName(),
            gender: $message->getGender(),
            species: $species,
            age: $message->getAge(),
            eyesColor: $message->getEyesColor()
        );

        $this->entityManager->persist($dino);
        $this->entityManager->flush();
    }
}
