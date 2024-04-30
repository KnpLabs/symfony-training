<?php

declare(strict_types=1);

namespace Domain\UseCase\EditSpecies;

use Domain\ReadModel\Species;

final readonly class Input
{
    public function __construct(
        public string $speciesId,
        public string $name,
        public array $habitats,
        public string $feeding
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
