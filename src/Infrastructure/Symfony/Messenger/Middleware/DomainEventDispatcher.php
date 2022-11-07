<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Messenger\Middleware;

use Application\MessageBus\EventBus;
use Doctrine\ORM\EntityManagerInterface;
use Domain\EventsRegisterer;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class DomainEventDispatcher implements MiddlewareInterface
{
    public function __construct(
        private EventBus $eventBus,
        private EventsRegisterer $eventsRegisterer,
        private EntityManagerInterface $em
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        $stamp = $envelope->last(HandledStamp::class);

        if (!$stamp instanceof HandledStamp) {
            return $envelope;
        }

        /*
         * This entity manager clear operation is mandatory since we need to have
         * the freshest object as possible as we always read entities after several
         * changes that might not have been updated by doctrine.
         */
        $this->em->clear();

        $events = $this->eventsRegisterer->getEvents();

        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }

        $this->eventsRegisterer->flush();

        return $envelope;
    }
}
