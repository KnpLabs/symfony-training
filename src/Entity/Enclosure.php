<?php

namespace App\Entity;

use App\Entity\Dinosaur;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class Enclosure
{
    private int $id;
    private string $name;
    private string $fences;
    private array $habitats;
    private array $feeding;
    private Collection $dinosaurs;

    public function __construct(
        string $name,
        string $fences,
        array $habitats,
        array $feeding
    ) {
        $this->name = $name;
        $this->fences = $fences;
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

    public function getFences(): string
    {
        return $this->fences;
    }

    public function setFences(string $fences): void
    {
        $this->fences = $fences;
    }

    public function getHabitats(): array
    {
        return $this->habitats;
    }

    public function setHabitats(array $habitats): void
    {
        $this->habitats = $habitats;
    }

    public function getFeeding(): array
    {
        return $this->feeding;
    }

    public function setFeeding(array $feeding): void
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
        $this->dinosaurs->remove($dinosaur);
    }
}