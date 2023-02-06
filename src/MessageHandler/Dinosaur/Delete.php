<?php

namespace App\MessageHandler\Dinosaur;

use App\Entity\Dinosaur;
use App\Message\Dinosaur\Delete as DeleteMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class Delete implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(DeleteMessage $message): void
    {
        $dinoRepository = $this->entityManager->getRepository(Dinosaur::class);

        if (!$dinosaur = $dinoRepository->find($message->id)) {
            throw new NotFoundHttpException("Dinosaur with id {$message->id} not found");
        }

        $this->entityManager->remove($dinosaur);
        $this->entityManager->flush();
    }
}
