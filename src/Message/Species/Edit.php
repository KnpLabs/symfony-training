<?php

namespace App\Message\Species;

class Edit
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $feeding,
        public readonly array $habitats
    ) {
    }
}
