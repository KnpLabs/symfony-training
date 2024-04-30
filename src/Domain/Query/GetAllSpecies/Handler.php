<?php

declare(strict_types=1);

namespace Domain\Query\GetAllSpecies;

use Domain\Collection\SpeciesCollection;
use Domain\Model\Species as ModelSpecies;
use Domain\ReadModel\Species;

final readonly class Handler
{
    public function __construct(
        private SpeciesCollection $speciesCollection
    ) {
    }

    public function __invoke(Query $query): array
    {
        $species = $this->speciesCollection->findAll();

        return array_map(
            fn (ModelSpecies $species) => new Species($species),
            $species
        );
    }
}
