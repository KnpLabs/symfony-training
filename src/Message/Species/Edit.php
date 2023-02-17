<?php

namespace App\Message\Species;

class Edit
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $feeding,
        public readonly array $habitats
    ) {
    }
}
