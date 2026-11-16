<?php

declare(strict_types=1);

namespace Domain\UseCase\RemoveSpecies;

final readonly class Input
{
    public function __construct(
        public string $id,
    ) {
    }
}
