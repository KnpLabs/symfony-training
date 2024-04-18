<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Species
{
    private int $id;
    private Collection $dinosaurs;

    public function __construct(
        private string $name,
        private array $habitats,
        private string $feeding,
    ) {
        $this->name = $name;
        $this->habitats = $habitats;
        $this->feeding = $feeding;
        $this->dinosaurs = new ArrayCollection();
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

    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur): void
    {
        $this->dinosaurs->add($dinosaur);
    }

    public function removeDinosaur(Dinosaur $dinosaur): void
    {
        $this->dinosaurs->removeElement($dinosaur);
    }
}
