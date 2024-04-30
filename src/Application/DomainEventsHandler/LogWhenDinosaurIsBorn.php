<?php

declare(strict_types=1);

namespace Application\DomainEventsHandler;

use Domain\Collection\DinosaursCollection;
use Domain\Event\DinosaurIsBorn;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class LogWhenDinosaurIsBorn
{
    public function __construct(
        private readonly DinosaursCollection $dinosaursCollection,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(DinosaurIsBorn $event): void
    {
        $dinosaurId = $event->getAggregateRootId();

        $dinosaur = $this->dinosaursCollection->find($dinosaurId);

        $this->logger->info(sprintf(
            'Dinosaur %s was born',
            $dinosaur->getName()
        ));
    }
}
