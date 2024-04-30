<?php

declare(strict_types=1);

namespace Application\DomainEventsHandler;

use Domain\Event\DinosaurDied;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class LogWhenDinosaurDied
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(DinosaurDied $event): void
    {
        $this->logger->info(sprintf(
            'Dinosaur %s died',
            $event->dinosaurName
        ));
    }
}
