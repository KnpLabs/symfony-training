<?php

declare(strict_types=1);

namespace Domain\UseCase\EditDinosaur;

use Domain\Collection\DinosaursCollection;
use Domain\Collection\SpeciesCollection;
use Domain\Exception\DinosaurAlreadyExistsException;
use Domain\Exception\SpeciesNotFoundException;

class Handler
{
    public function __construct(
        private DinosaursCollection $dinosaursCollection,
        private SpeciesCollection $speciesCollection
    ) {
    }

    public function __invoke(Input $input): Output
    {
        $dinosaur = $this
            ->dinosaursCollection
            ->find($input->id)
        ;

        if (null === $dinosaur) {
            throw new DinosaurAlreadyExistsException($input->name);
        }

        $species = $this
            ->speciesCollection
            ->find($input->speciesId)
        ;

        if (null === $species) {
            throw new SpeciesNotFoundException($input->speciesId);
        }

        $dinosaur->setName($input->name);
        $dinosaur->setGender($input->gender);
        $dinosaur->setSpecies($species);
        $dinosaur->setAge($input->age);
        $dinosaur->setEyesColor($input->eyesColor);

        return new Output($dinosaur);
    }
}
