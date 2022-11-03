<?php

declare(strict_types=1);

namespace Domain\UseCase\EditSpecies;

use Domain\Collection\SpeciesCollection;
use Domain\Exception\SpeciesNotFoundException;
use Domain\Model\Species;

class Handler
{
    public function __construct(
        private SpeciesCollection $speciesCollection,
    ) {
    }

    public function __invoke(Input $input): Output
    {
        /** @var ?Species */
        $species = $this->speciesCollection->find($input->speciesId);

        if (null === $species) {
            throw new SpeciesNotFoundException($input->speciesId);
        }

        $species->setName($input->name);
        $species->setHabitats($input->habitats);
        $species->setFeeding($input->feeding);

        $this->speciesCollection->add($species);

        return new Output($species);
    }
}
