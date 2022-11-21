<?php

namespace App\MessageHandler;

use App\Entity\Species;
use App\Message\DeleteSpecies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteSpeciesHandler implements MessageHandlerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(DeleteSpecies $message)
    {
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        if (!$species = $speciesRepository->find($message->getId())) {
            throw new NotFoundHttpException("Species with id {$message->getId()} not found");
        }

        $this->entityManager->remove($species);
        $this->entityManager->flush();
    }
}
