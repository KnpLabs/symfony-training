<?php

namespace App\Entity;

use App\Entity\Category;
use App\Entity\Reservation;

class Ticket
{
    private int $id;
    private string $visitorName;
    private Category $category;
    private ?Reservation $reservation;

    public function __construct(
        string $visitorName,
        Category $category
    ) {
        $this->visitorName = $visitorName;
        $this->category = $category;
        $this->reservation = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getVisitorName(): string
    {
        return $this->visitorName;
    }

    public function setVisitorName(string $visitorName): void
    {
        $this->visitorName = $visitorName;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): void
    {
        $this->reservation = $reservation;
    }

    public function cancelReservation(): void
    {
        $this->reservation = null;
    }
}