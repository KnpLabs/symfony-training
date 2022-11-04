<?php

declare(strict_types=1);

namespace Domain\UseCase\RemoveSpecies;

final class Input
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
