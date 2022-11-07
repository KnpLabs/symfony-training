<?php

declare(strict_types=1);

namespace Application\MessageBus;

interface EventBus
{
    public function dispatch(object $event): void;
}
