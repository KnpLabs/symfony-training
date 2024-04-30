<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Messenger;

use Application\MessageBus\EventBus as EventBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class EventBus implements EventBusInterface
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function dispatch(object $event): void
    {
        try {
            $this->handle($event);
        } catch (HandlerFailedException $handlerFailedException) {
            $nestedExceptions = $handlerFailedException->getWrappedExceptions();

            if (false === $nested = current($nestedExceptions)) {
                throw $handlerFailedException;
            }

            throw $nested;
        }
    }
}
