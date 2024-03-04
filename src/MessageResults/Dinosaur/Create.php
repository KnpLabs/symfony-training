<?php

declare(strict_types=1);

namespace App\MessageResults\Dinosaur;

class Create
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
