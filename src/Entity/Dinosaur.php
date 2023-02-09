<?php

namespace App\Entity;

class Dinosaur
{
    private int $id;

    public function __construct(
        private string $name,
        private string $gender,
        private Species $species,
        private int $age,
        private string $eyesColor,
        private Park $park
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getSpecies(): Species
    {
        return $this->species;
    }

    public function setSpecies(Species $species): void
    {
        $this->species = $species;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getEyesColor(): string
    {
        return $this->eyesColor;
    }

    public function setEyesColor(string $eyesColor): void
    {
        $this->eyesColor = $eyesColor;
    }

    public function getPark(): Park
    {
        return $this->park;
    }

    public function setPark(Park $park): void
    {
        $this->park = $park;
    }
}
