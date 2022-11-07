<?php

declare(strict_types=1);

namespace Application\DomainEventsHandler;

use Domain\Event\DinosaurDied;
use Domain\Event\EventInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class LogWhenDinosaurDied implements MessageSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(EventInterface $event): void
    {
        if (!$event instanceof DinosaurDied) {
            return;
        }

        $this->logger->info(sprintf(
            'Dinosaur %s died',
            $event->getDinosaurName()
        ));
    }

    public static function getHandledMessages(): iterable
    {
        yield DinosaurDied::class;
    }
}
