<?php

declare(strict_types=1);

namespace Domain\UseCase\EditSpecies;

use Domain\ReadModel\Species;

final class Input
{
    public function __construct(
        public readonly string $speciesId,
        public readonly string $name,
        public readonly array $habitats,
        public readonly string $feeding
    ) {
    }

    public static function fromReadModel(Species $species): self
    {
        return new self(
            speciesId: (string) $species->getId(),
            name: $species->getName(),
            habitats: $species->getHabitats(),
            feeding: $species->getFeeding()
        );
    }
}
