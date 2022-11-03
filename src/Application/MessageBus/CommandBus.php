<?php

declare(strict_types=1);

namespace Application\MessageBus;

interface CommandBus
{
    public function dispatch(object $input): mixed;
}
