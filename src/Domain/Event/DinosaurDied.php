<?php

declare(strict_types=1);

namespace Domain\Event;

final readonly class DinosaurDied implements EventInterface
{
    public function __construct(
        public int $dinosaurId,
        public string $dinosaurName,
    ) {
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->dinosaurId;
    }
}
