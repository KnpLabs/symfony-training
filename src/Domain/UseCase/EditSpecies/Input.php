<?php

declare(strict_types=1);

namespace Domain\UseCase\EditSpecies;

final class Input
{
    public function __construct(
        public readonly string $speciesId,
        public readonly string $name,
        public readonly array $habitats,
        public readonly string $feeding
    ) {
    }
}
