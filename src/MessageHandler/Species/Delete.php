<?php

namespace App\MessageHandler\Species;

use App\Entity\Species;
use App\Message\Species\Delete as DeleteMessage;
use App\Repository\SpeciesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Delete
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SpeciesRepository $speciesRepository,
    ) {
    }

    public function __invoke(DeleteMessage $message)
    {
        if (!$species = $this->speciesRepository->find($message->id)) {
            throw new NotFoundHttpException("Species with id {$message->id} not found");
        }

        $this->entityManager->remove($species);
    }
}
