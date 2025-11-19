<?php

declare(strict_types=1);

namespace Infrastructure\Symfony\Messenger;

use Application\MessageBus\QueryBus as QueryBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function dispatch(object $input): mixed
    {
        try {
            return $this->handle($input);
        } catch (HandlerFailedException $handlerFailedException) {
            $nestedExceptions = $handlerFailedException->getWrappedExceptions();

            if (false === $nested = current($nestedExceptions)) {
                throw $handlerFailedException;
            }

            throw $nested;
        }
    }
}
