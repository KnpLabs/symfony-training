<?php

namespace App\Message\Species;

class Create
{
    public function __construct(
        public readonly string $name,
        public readonly string $feeding,
        public readonly array $habitats
    ) {
    }
}
