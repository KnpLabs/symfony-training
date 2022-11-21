<?php

namespace App\MessageHandler;

use App\Entity\Species;
use App\Message\EditSpecies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class EditSpeciesHandler implements MessageHandlerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(EditSpecies $message): void
    {
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        if (!$species = $speciesRepository->find($message->getId())) {
            throw new NotFoundHttpException("Species with id {$message->getId()} not found");
        }

        $species->setName($message->getName());
        $species->setFeeding($message->getFeeding());
        $species->setHabitats($message->getHabitats());

        $this->entityManager->flush();
    }
}
