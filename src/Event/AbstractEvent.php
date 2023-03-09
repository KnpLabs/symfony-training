<?php

declare(strict_types=1);

namespace App\Event;

class AbstractEvent
{
    public function __construct(
        private string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
