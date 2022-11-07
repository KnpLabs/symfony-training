<?php

declare(strict_types=1);

namespace Domain\Event;

use Domain\Model\Dinosaur;

class DinosaurIsBorn implements EventInterface
{
    public function __construct(
        private Dinosaur $dinosaur
    ) {
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->dinosaur->getId();
    }
}