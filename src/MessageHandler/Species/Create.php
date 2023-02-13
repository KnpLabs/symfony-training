<?php

namespace App\MessageHandler\Species;

use App\Entity\Species;
use App\Message\Species\Create as CreateMessage;
use App\MessageResults\Species\Create as CreateMessageResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Create
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateMessage $message): CreateMessageResult
    {
        $species = new Species(
            name: $message->name,
            habitats: $message->habitats,
            feeding: $message->feeding
        );

        $this->entityManager->persist($species);
        $this->entityManager->flush();

        return new CreateMessageResult($species->getId());
    }
}
