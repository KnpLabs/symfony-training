<?php

declare(strict_types=1);

namespace Domain\UseCase\EditDinosaur;

use Domain\ReadModel\Dinosaur;

final class Input
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $gender,
        public readonly string $speciesId,
        public readonly int $age,
        public readonly string $eyesColor
    ) {
    }

    public static function fromReadModel(Dinosaur $dinosaur): self
    {
        return new self(
            (string) $dinosaur->getId(),
            $dinosaur->getName(),
            $dinosaur->getGender(),
            (string) $dinosaur->getSpecies()->getId(),
            $dinosaur->getAge(),
            $dinosaur->getEyesColor()
        );
    }
}