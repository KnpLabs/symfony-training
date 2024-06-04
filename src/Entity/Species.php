<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Species
{
    private int $id;
    private Collection $dinosaurs;
    private Collection $habitats;

    /**
     * @param Habitat[] $habitats
     */
    public function __construct(
        private string $name,
        private string $feeding,
        ?Collection $habitats = null
    ) {
        $this->dinosaurs = new ArrayCollection();

        if ($habitats !== null) {
            $this->habitats = $habitats;
        }
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

    public function getHabitats(): Collection
    {
        return $this->habitats;
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
