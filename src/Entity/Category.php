<?php

namespace App\Entity;

class Category
{
    private int $id;
    private string $name;
    private int $price;

    public function __construct(
        string $name,
        int $price
    ) {
        $this->name = $name;
        $this->price = $price;
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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function isAdult(): bool
    {
        return (!str_contains($this->name, 'Child') && !str_contains($this->name, 'Toddler'));
    }
}