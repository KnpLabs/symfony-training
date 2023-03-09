<?php

declare(strict_types=1);

namespace App\MessageResults\Species;

class Create
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
