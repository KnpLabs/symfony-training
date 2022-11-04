<?php

declare(strict_types=1);

namespace Domain\ReadModel;

use Domain\Model\Dinosaur as ModelDinosaur;

final class Dinosaur
{
    private int $id;
    private string $name;
    private string $gender;
    private Species $species;
    private int $age;
    private string $eyesColor;

    public function __construct(ModelDinosaur $dinosaurModel)
    {
        $this->id = $dinosaurModel->getId();
        $this->name = $dinosaurModel->getName();
        $this->gender = $dinosaurModel->getGender();
        $this->species = new Species($dinosaurModel->getSpecies());
        $this->age = $dinosaurModel->getAge();
        $this->eyesColor = $dinosaurModel->getEyesColor();
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
