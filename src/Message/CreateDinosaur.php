<?php

namespace App\Message;

class CreateDinosaur
{
    public function __construct(
        private string $name,
        private string $gender,
        private string $eyesColor,
        private int $age,
        private int $speciesId
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getEyesColor(): string
    {
        return $this->eyesColor;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getSpeciesId(): int
    {
        return $this->speciesId;
    }
}
