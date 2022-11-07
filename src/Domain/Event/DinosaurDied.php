<?php

declare(strict_types=1);

namespace Domain\Event;

use Domain\Model\Dinosaur;

final class DinosaurDied implements EventInterface
{
    private string $dinosaurName;

    public function __construct(private Dinosaur $dinosaur)
    {
        $this->dinosaurName = $dinosaur->getName();
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->dinosaur->getId();
    }

    public function getDinosaurName(): string
    {
        return $this->dinosaurName;
    }
}
