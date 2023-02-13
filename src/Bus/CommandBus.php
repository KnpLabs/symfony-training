<?php

declare(strict_types=1);

namespace App\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $messageBus
    ) {
    }

    public function dispatch(object $input): object
    {
        return $this->handle($input);
    }
}
