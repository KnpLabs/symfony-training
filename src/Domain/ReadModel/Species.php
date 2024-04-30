<?php

declare(strict_types=1);

namespace Domain\ReadModel;

use Domain\Model\Species as ModelSpecies;

final class Species
{
    private int $id;
    private string $name;
    private array $habitats;
    private string $feeding;

    public function __construct(
        ModelSpecies $modelSpecies,
    ) {
        $this->id = $modelSpecies->getId();
        $this->name = $modelSpecies->getName();
        $this->habitats = $modelSpecies->getHabitats();
        $this->feeding = $modelSpecies->getFeeding();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getHabitats(): array
    {
        return $this->habitats;
    }

    public function setHabitats(array $habitats): void
    {
        $this->habitats = $habitats;
    }

    public function getFeeding(): string
    {
        return $this->feeding;
    }

    public function setFeeding(string $feeding): void
    {
        $this->feeding = $feeding;
    }
}
