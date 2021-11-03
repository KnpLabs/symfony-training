<?php

namespace App\Entity;

class Dinosaur
{
    private string $name;
    private string $gender;
    private string $species;
    private int $age;

    public function __construct(
        string $name,
        string $gender,
        string $species,
        int $age
    ) {
        $this->name = $name;
        $this->gender = $gender;
        $this->species = $species;
        $this->age = $age;
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

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function setSpecies(string $species): void
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
}
