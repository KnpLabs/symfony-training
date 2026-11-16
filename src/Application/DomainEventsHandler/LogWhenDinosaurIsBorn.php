<?php

declare(strict_types=1);

namespace Application\DomainEventsHandler;

use Domain\Collection\DinosaursCollection;
use Domain\Event\DinosaurIsBorn;
use Domain\Exception\DinosaurNotFoundException;
use Domain\Model\Dinosaur;
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

        if (!$dinosaur instanceof Dinosaur) {
            throw new DinosaurNotFoundException($dinosaurId);
        }

        $this->logger->info(\sprintf(
            'Dinosaur %s was born',
            $dinosaur->getName()
        ));
    }
}
