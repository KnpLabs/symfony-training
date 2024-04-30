<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateSpecies;

final readonly class Input
{
    public function __construct(
        public string $name,
        public array $habitats,
        public string $feeding,
    ) {
    }
}
