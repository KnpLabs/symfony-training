<?php

declare(strict_types=1);

namespace Domain\Event;

interface EventInterface
{
    public function getAggregateRootId(): string;
}
