<?php

namespace App\Entity;

use App\Entity\Species;
use App\Entity\EyesColor;
use App\Entity\Enclosure;

class Dinosaur
{
    private int $id;
    private string $name;
    private string $gender;
    private Species $species;
    private int $age;
    private EyesColor $eyesColor;
    private ?Enclosure $enclosure;

    public function __construct(
        string $name,
        string $gender,
        Species $species,
        int $age,
        EyesColor $eyesColor,
        ?Enclosure $enclosure = null
    ) {
        $this->name = $name;
        $this->gender = $gender;
        $this->species = $species;
        $this->age = $age;
        $this->eyesColor = $eyesColor;
        $this->enclosure = $enclosure;
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

    public function getEyesColor(): EyesColor
    {
        return $this->eyesColor;
    }

    public function setEyesColor(EyesColor $eyesColor): void
    {
        $this->eyesColor = $eyesColor;
    }

    public function getEnclosure(): Enclosure
    {
        return $this->enclosure;
    }

    public function setEnclosure(Enclosure $enclosure): void
    {
        $this->enclosure = $enclosure;
    }
}
