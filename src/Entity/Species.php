<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

class Species
{
    private ?Uuid $id;
    private Collection $dinosaurs;

    public function __construct(
        private string $name,
        private array $habitats,
        private string $feeding,
        ?Uuid $id = null
    ) {
        $this->id = $id ?? Uuid::v4();
        $this->dinosaurs = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(?Uuid $id): void
    {
        $this->id = $id;
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
