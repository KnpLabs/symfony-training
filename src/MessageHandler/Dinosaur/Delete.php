<?php

namespace App\MessageHandler\Dinosaur;

use App\Entity\Dinosaur;
use App\Message\Dinosaur\Delete as DeleteMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Delete
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DeleteMessage $message)
    {
        $dinoRepository = $this->entityManager->getRepository(Dinosaur::class);

        if (!$dinosaur = $dinoRepository->find($message->id)) {
            throw new NotFoundHttpException("Dinosaur with id {$message->id} not found");
        }

        $this->entityManager->remove($dinosaur);
        $this->entityManager->flush();
    }
}
