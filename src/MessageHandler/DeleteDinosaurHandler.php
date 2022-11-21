<?php

namespace App\MessageHandler;

use App\Entity\Dinosaur;
use App\Message\DeleteDinosaur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteDinosaurHandler implements MessageHandlerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(DeleteDinosaur $message): void
    {
        $dinoRepository = $this->entityManager->getRepository(Dinosaur::class);

        if (!$dinosaur = $dinoRepository->find($message->getId())) {
            throw new NotFoundHttpException("Dinosaur with id {$message->getId()} not found");
        }

        $this->entityManager->remove($dinosaur);
        $this->entityManager->flush();
    }
}
