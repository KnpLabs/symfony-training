<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class Reservation
{
    private int $id;
    private User $buyer;
    private \DateTime $dateOfVisit;
    private Collection $tickets;
    private \DateTime $createdAt;
    private ?string $gift;

    public function __construct(
        User $buyer,
        \DateTime $dateOfVisit,
        array $tickets,
        ?string $gift = null
    ) {
        $this->buyer = $buyer;
        $this->dateOfVisit = $dateOfVisit;
        $this->tickets = new ArrayCollection($tickets);
        $this->createdAt = new \DateTime();
        $this->assignTicketsToReservation();
        $this->gift = $gift;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBuyer(): User
    {
        return $this->buyer;
    }

    public function setBuyer(User $buyer): void
    {
        $this->buyer = $buyer;
    }

    public function getDateOfVisit(): \DateTime
    {
        return $this->dateOfVisit;
    }

    public function setDateOfVisit(\DateTime $dateOfVisit): void
    {
        $this->dateOfVisit = $dateOfVisit;
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    /**
     * @param array<Ticket> $tickets
     */
    public function addTickets(array $tickets): void
    {
        foreach ($tickets as $ticket) {
            $this->addTicket($ticket);
        }

        $this->assignTicketsToReservation();
    }

    private function assignTicketsToReservation(): void
    {
        $this->tickets->forAll(function ($key, Ticket $ticket) {
            $ticket->setReservation($this);

            return true;
        });
    }

    public function addTicket(Ticket $ticket): void
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setReservation($this);
        }
    }

    public function removeTicket(Ticket $ticket): void
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            $ticket->cancelReservation();
        }
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getTotalPrice(): int
    {
        $totalPrice = 0;

        foreach ($this->tickets as $ticket) {
            $totalPrice += $ticket->getCategory()->getPrice();
        }

        return $totalPrice;
    }

    public function getGift(): ?string
    {
        return $this->gift;
    }

    public function setGift(?string $gift): void
    {
        $this->gift = $gift;
    }
}