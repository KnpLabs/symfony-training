<?php

namespace App\Message\Dinosaur;

class Create
{
    public function __construct(
        public readonly string $name,
        public readonly string $gender,
        public readonly string $eyesColor,
        public readonly int $age,
        public readonly string $speciesId,
        public readonly int $parkId,
    ) {
    }
}
