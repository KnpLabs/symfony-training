<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateDinosaur;

final readonly class Input
{
    public function __construct(
        public string $name,
        public string $gender,
        public string $speciesId,
        public int $age,
        public string $eyesColor
    ) {
    }
}
