<?php

namespace App\Entity;

class Dinosaur
{
    private int $id;
    private string $name;
    private string $gender;
    private Species $species;
    private int $age;
    private string $eyesColor;

    public function __construct(
        string $name,
        string $gender,
        Species $species,
        int $age,
        string $eyesColor
    ) {
        $this->name = $name;
        $this->gender = $gender;
        $this->species = $species;
        $this->age = $age;
        $this->eyesColor = $eyesColor;
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
}
