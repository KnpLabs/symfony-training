<?php

declare(strict_types=1);

namespace App\Event;

class AbstractEvent implements Event
{
    public function __construct(
        private int $id
    ) {
    }

    public function getAggregateRootId(): int
    {
        return $this->id;
    }
}
