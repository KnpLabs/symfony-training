<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateDinosaur;

final class Input
{
    public function __construct(
        public readonly string $name,
        public readonly string $gender,
        public readonly string $speciesId,
        public readonly int $age,
        public readonly string $eyesColor
    ) {
    }
}