<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Dinosaur;
use Doctrine\Common\Collections\Collection;

class Park
{
    private int $id;

    private string $name;

    private Collection $dinosaurs;

    private int $foodAmount;

    public function __construct(
        string $name,
        int $foodAmount
    ) {
        $this->name = $name;
        $this->foodAmount = $foodAmount;
        $this->dinosaurs = [];
    }

    public function addDinosaurs(Dinosaur ...$dinosaur): void
    {
        $this->dinosaurs[] = $dinosaur;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFoodAmount(): int
    {
        return $this->foodAmount;
    }

    public function setFoodAmount(int $foodAmount): void
    {
        $this->foodAmount = $foodAmount;
    }

    public function getDinosaurs()
    {
        return $this->dinosaurs;
    }
}
