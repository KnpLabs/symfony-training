<?php

namespace App\Entity;

class EyesColor
{
    private int $id;
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(
        int $red,
        int $green,
        int $blue
    ) {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function setRed(int $red): void
    {
        $this->red = $red;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }

    public function setBlue(int $blue): void
    {
        $this->blue = $blue;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function setGreen(int $green): void
    {
        $this->green = $green;
    }

    public function __toString(): string
    {
        return sprintf('#%02x%02x%02x', $this->red, $this->green, $this->blue);
    }
}