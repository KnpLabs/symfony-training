<?php

declare(strict_types=1);

namespace Application\DomainEventsHandler;

use Domain\Collection\DinosaursCollection;
use Domain\Event\DinosaurIsBorn;
use Domain\Event\EventInterface;
use Domain\Exception\DinosaurNotFoundException;
use Domain\Model\Dinosaur;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class LogWhenDinosaurIsBorn implements MessageSubscriberInterface
{
    public function __construct(
        private DinosaursCollection $dinosaursCollection,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(EventInterface $event): void
    {
        $dinosaurId = $event->getAggregateRootId();

        $dinosaur = $this->dinosaursCollection->find($dinosaurId);

        if (!$dinosaur instanceof Dinosaur) {
            throw new DinosaurNotFoundException($dinosaurId);
        }

        $this->logger->info(sprintf(
            'Dinosaur %s was born',
            $dinosaur->getName()
        ));
    }

    public static function getHandledMessages(): iterable
    {
        yield DinosaurIsBorn::class;
    }
}
