<?php

declare(strict_types=1);

namespace App\Event;

interface Event
{
    public function getAggregateRootId(): int;
}
