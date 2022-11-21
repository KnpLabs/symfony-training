<?php

namespace App\MessageHandler;

use App\Entity\Species;
use App\Message\CreateSpecies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateSpeciesHandler implements MessageHandlerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(CreateSpecies $message): void
    {
        $species = new Species(
            name: $message->getName(),
            habitats: $message->getHabitats(),
            feeding: $message->getFeeding()
        );

        $this->entityManager->persist($species);
        $this->entityManager->flush();
    }
}
