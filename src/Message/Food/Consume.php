<?php

declare(strict_types=1);

namespace App\Message\Food;

class Consume
{
    public function __construct(
        public readonly int $dinosaurId,
        public readonly string $dinosaurName
    ) {
    }
}
