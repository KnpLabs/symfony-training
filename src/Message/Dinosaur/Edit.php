<?php

namespace App\Message\Dinosaur;

class Edit
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $gender,
        public readonly string $eyesColor,
        public readonly int $age,
        public readonly int $speciesId
    ) {
    }
}
