<?php

namespace App\Message;

class CreateSpecies
{
    public function __construct(
        private string $name,
        private string $feeding,
        private array $habitats
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFeeding(): string
    {
        return $this->feeding;
    }

    public function getHabitats(): array
    {
        return $this->habitats;
    }
}
