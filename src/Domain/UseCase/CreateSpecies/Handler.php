<?php

declare(strict_types=1);

namespace Domain\UseCase\CreateSpecies;

use Domain\Collection\SpeciesCollection;
use Domain\Exception\SpeciesAlreadyExistsException;
use Domain\Model\Species;

final readonly class Handler
{
    public function __construct(
        private SpeciesCollection $speciesCollection,
    ) {
    }

    public function __invoke(Input $input): Output
    {
        if (null !== $this->speciesCollection->findByName($input->name)) {
            throw new SpeciesAlreadyExistsException($input->name);
        }

        $species = new Species(
            $input->name,
            $input->habitats,
            $input->feeding,
        );

        $this->speciesCollection->add($species);

        return new Output($species);
    }
}
