<?php

declare(strict_types=1);

namespace Domain\UseCase\RemoveSpecies;

use Domain\Collection\SpeciesCollection;
use Domain\Exception\SpeciesNotFoundException;

class Handler
{
    public function __construct(
        private SpeciesCollection $speciesCollection
    ) {}

    public function __invoke(Input $input): Output
    {
        $species = $this->speciesCollection->find($input->id);

        if (null === $species) {
            throw new SpeciesNotFoundException($input->id);
        }

        $this->speciesCollection->remove($species);

        return new Output();
    }
}
