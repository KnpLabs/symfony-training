<?php

namespace App\MessageHandler;

use App\Entity\Species;
use App\Message\Species\Delete as DeleteMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class Delete implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DeleteMessage $message)
    {
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        if (!$species = $speciesRepository->find($message->id)) {
            throw new NotFoundHttpException("Species with id {$message->id} not found");
        }

        $this->entityManager->remove($species);
        $this->entityManager->flush();
    }
}
