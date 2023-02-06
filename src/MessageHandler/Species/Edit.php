<?php

namespace App\MessageHandler;

use App\Entity\Species;
use App\Message\Species\Edit as EditMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class Edit implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(EditMessage $message): void
    {
        $speciesRepository = $this->entityManager->getRepository(Species::class);

        if (!$species = $speciesRepository->find($message->id)) {
            throw new NotFoundHttpException("Species with id {$message->id} not found");
        }

        $species->setName($message->name);
        $species->setFeeding($message->feeding);
        $species->setHabitats($message->habitats);

        $this->entityManager->flush();
    }
}
