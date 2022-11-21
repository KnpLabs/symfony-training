<?php

namespace App\Message;

class EditSpecies
{
    public function __construct(
        private int $id,
        private string $name,
        private string $feeding,
        private array $habitats
    ) {
    }

    public function getId(): int
    {
        return $this->id;
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
