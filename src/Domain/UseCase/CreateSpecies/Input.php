<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateSpecies;

final class Input
{
    public function __construct(
        public readonly string $name,
        public readonly array $habitats,
        public readonly string $feeding,
    ) {
    }
}
