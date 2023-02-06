<?php

namespace App\MessageHandler\Species;

use App\Entity\Species;
use App\Message\Species\Create as CreateMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class Create implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateMessage $message): void
    {
        $species = new Species(
            name: $message->name,
            habitats: $message->habitats,
            feeding: $message->feeding
        );

        $this->entityManager->persist($species);
        $this->entityManager->flush();
    }
}
