<?php

declare(strict_types=1);

namespace Domain;

use Domain\Event\EventInterface;

trait HasEventsRegisterer
{
    private EventsRegisterer $eventsRegisterer;

    /**
     * @required
     */
    public function setEventsRegisterer(EventsRegisterer $eventsRegisterer): void
    {
        $this->eventsRegisterer = $eventsRegisterer;
    }

    public function getEventsRegisterer(): EventsRegisterer
    {
        return $this->eventsRegisterer;
    }

    public function registerEvents(EventInterface ...$events): void
    {
        $this->eventsRegisterer->register(...$events);
    }
}
