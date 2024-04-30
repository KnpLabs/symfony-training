<?php

namespace Domain\Model;

class Species
{
    private int $id;
    private iterable $dinosaurs;

    public function __construct(
        private string $name,
        private array $habitats,
        private string $feeding,
    ) {
        $this->name = $name;
        $this->habitats = $habitats;
        $this->feeding = $feeding;
        $this->dinosaurs = [];
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

    public function getDinosaurs(): iterable
    {
        yield from $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur): void
    {
        $this->dinosaurs[] = $dinosaur;
    }

    public function removeDinosaur(Dinosaur $dinosaur): void
    {
        $this->dinosaurs = array_filter(
            [...$this->dinosaurs],
            function (Dinosaur $d) use ($dinosaur) {
                return $d->getId() !== $dinosaur->getId();
            }
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'habitats' => $this->habitats,
            'feeding' => $this->feeding,
        ];
    }
}
