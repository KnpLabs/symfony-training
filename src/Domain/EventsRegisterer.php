<?php

declare(strict_types=1);

namespace Domain;

use Domain\Event\EventInterface;

final class EventsRegisterer
{
    /** @var array<EventInterface> */
    private array $events = [];

    public function register(EventInterface ...$events): void
    {
        array_push($this->events, ...$events);
    }

    /**
     * @return array<EventInterface>
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function flush(): void
    {
        $this->events = [];
    }
}
