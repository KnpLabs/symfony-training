<?php

declare(strict_types=1);

namespace Domain\Query\GetSingleSpecies;

use Domain\Collection\SpeciesCollection;
use Domain\Exception\SpeciesNotFoundException;
use Domain\ReadModel\Species;

class Handler
{
    public function __construct(
        private readonly SpeciesCollection $speciesCollection,
    ) {
    }

    public function __invoke(Query $query): Species
    {
        $speciesModel = $this->speciesCollection->find($query->id);

        if ($speciesModel === null) {
            throw new SpeciesNotFoundException($query->id);
        }

        return new Species($speciesModel);
    }
}
