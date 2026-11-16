<?php

namespace Domain\Model;

use DateTime;

class Dinosaur implements AggregateRoot
{
    private int $id;

    public function __construct(
        private string $name,
        private string $gender,
        private Species $species,
        private int $age,
        private DateTime $birthDate,
        private string $eyesColor,
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
    public function getBirthDate(): DateTime
    {
        return $this->birthDate;
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'species' => $this->species,
            'age' => $this->age,
            'birthdate' => $this->birthDate,
            'eyesColor' => $this->eyesColor,
        ];
    }
}
